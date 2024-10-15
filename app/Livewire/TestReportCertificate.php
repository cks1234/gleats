<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;

class TestReportCertificate extends Component
{
    public $job;
    public $job_id;
    public $sections = [];
    public $current_section_index = 0;
    public $current_question_index = 0;
    public $response = '';
    public $responses = [];
    public $response_prompt = '';
    public $show_prompt = false;
    public $prompt_current = '';
    public $prompt_next = '';
    public $error = '';

    public function mount($job_id)
    {
        $this->job = Job::findOrFail($job_id);
        $this->job_id = $job_id;

        if (auth()->id() !== $this->job->supervisor_id) {
            abort(403, 'You can only generate test report of your assigned jobs.');
        }

        $this->sections = json_decode(file_get_contents(public_path('test_report_template.json')), true)['sections'];
    }

    public function handle_next()
    {
        $current_question = $this->get_current_question();
        $response_validated = $this->validate_response($current_question);

        if (empty($response_validated)) {
            return;
        }

        $this->save_response($current_question, $this->response);

        if ($this->handle_prompt($current_question)) {
            return;
        }

        $next_step = $this->get_next_step($current_question, $response_validated);

        if ($this->move_to_next($next_step)) {
            return;
        }
    }

    private function validate_response($current_question)
    {
        $response_validated = $this->response;

        switch ($current_question['type']) {
            case 'yes_no':
                if ($this->response != 'yes' && $this->response != 'no') {
                    $this->error = 'Provide a response to proceed';
                    return;
                }
                break;

            case 'select':
                $options = $current_question['options'] ?? null;

                if (!in_array($this->response, $options)) {
                    $this->error = 'Response must be from given options';
                    return;
                }
                break;

            case 'dropdown':
                $options = $current_question['depends_on_options'] ?? null;

                if (!in_array($this->response, $options)) {
                    $this->error = 'Response must be from given options';
                    return;
                }
                $response_validated = "valid";
                break;

            case 'float':
                $nullable = $current_question['nullable'] ?? null;

                if ($nullable && empty($this->response)) {
                    $this->response = "N/A";
                    $response_validated = "valid";
                } else {
                    if (!is_numeric($this->response)) {
                        $this->error = 'Response must be a number';
                        return;
                    }

                    $min = $current_question['validation']['min'] ?? null;
                    $max = $current_question['validation']['max'] ?? null;

                    if (+$this->response < $min || +$this->response > $max) {
                        $response_validated = "invalid";
                    } else {
                        $response_validated = "valid";
                    }
                }
                break;

            case 'int':
                if (!is_numeric($this->response)) {
                    $this->error = 'Response must be a number';
                    return;
                }

                $min = $current_question['validation']['min'] ?? null;
                $max = $current_question['validation']['max'] ?? null;

                if (+$this->response < $min || +$this->response > $max) {
                    $response_validated = "invalid";
                } else {
                    $this->response = intval($this->response);
                    $response_validated = "valid";
                }
                break;

            case 'text':
                if (empty($this->response)) {
                    $response_validated = "invalid";
                } else {
                    $response_validated = "valid";
                }
                break;
        }

        if ($this->has_error($current_question, $response_validated)) {
            return;
        }

        return $response_validated;
    }

    private function has_error($current_question, $response_validated)
    {
        $next_step = $this->get_next_step($current_question, $response_validated);

        if (!empty($next_step['error'])) {
            $this->error = $next_step['error'];
            return true;
        }

        return false;
    }

    private function save_response($current_question, $response_validated)
    {
        $this->responses[] = [
            'id' => str_replace('_', '.', $this->get_current_question()['id']),
            'question' => $current_question['question'],
            'response' => $response_validated,
        ];
    }

    private function handle_prompt($current_question, $nested_prompt = false)
    {
        if ($nested_prompt) {
            $next_step = $current_question['next'];
        } else {
            $next_step = $this->get_next_step($current_question, $this->response);
        }

        $prompt = $next_step['prompt'] ?? null;

        if (isset($prompt['type']) && $prompt['type'] === 'action') {
            session()->flash('job', $this->job);
            session()->flash('responses', $this->responses);
            return redirect()->route('trc.preview');
        }

        if ($prompt) {
            $this->show_prompt = true;
            $this->prompt_current = $prompt;
            $this->prompt_next = $prompt['next'];
            $this->response_prompt = '';
            $this->error = '';
            return true;
        }

        return false;
    }

    public function submit_prompt()
    {
        $response_validated = $this->response_prompt;

        switch ($this->prompt_current['type']) {
            case 'yes_no':
                if ($this->response_prompt != 'yes' && $this->response_prompt != 'no') {
                    $this->error = 'Provide a response to proceed';
                    return;
                }
                break;

            case 'select':
                $options = $this->prompt_current['options'] ?? null;

                if (!in_array($this->response_prompt, $options)) {
                    $this->error = 'Response must be from given options';
                    return;
                }
                break;

            case 'float':
                if (!is_numeric($this->response_prompt)) {
                    $this->error = 'Response must be a number';
                    return;
                }

                $min = $this->prompt_current['validation']['min'] ?? null;
                $max = $this->prompt_current['validation']['max'] ?? null;

                if (+$this->response_prompt < $min || +$this->response_prompt > $max) {
                    $response_validated = "invalid";
                } else {
                    $response_validated = "valid";
                }
                break;
        }

        if ($this->has_error($this->prompt_current, $response_validated)) {
            return;
        }

        $this->responses[] = [
            'id' => str_replace('_', '.', $this->get_current_question()['id']),
            'question' => $this->prompt_current['text'],
            'response' => $this->response_prompt,
        ];

        if (isset($this->prompt_next['prompt'])) {
            if ($this->handle_prompt($this->prompt_current, $nested_prompt = true)) {
                return;
            }
        } elseif (!is_string($this->prompt_next)) {
            $next_step = $this->get_next_step($this->prompt_current, $response_validated);
            if ($this->move_to_next($next_step)) {
                return;
            }
        } else {
            if ($this->move_to_next($this->prompt_next)) {
                return;
            }
        }
    }

    private function move_to_next($next_id)
    {
        if (!$next_id || !is_string($next_id) || strpos($next_id, '_') === false) {
            $this->error = 'Invalid format for "next" key.';
            return true;
        }

        list($next_section_index, $next_question_index) = explode('_', $next_id);
        $next_section_index = (int)$next_section_index - 1;
        $next_question_index = (int)$next_question_index - 1;

        if (isset($this->sections[$next_section_index]['questions'][$next_question_index])) {
            $this->current_section_index = $next_section_index;
            $this->current_question_index = $next_question_index;
        } else {
            $this->error = 'Invalid step for "next" key.';
            return true;
        }

        $this->reset_properties();

        return false;
    }

    private function get_current_section()
    {
        return $this->sections[$this->current_section_index];
    }

    private function get_current_question()
    {
        $question = $this->get_current_section()['questions'][$this->current_question_index];

        if (isset($question['depends_on']) && $question['depends_on']) {
            $depends_on = $question['depends_on'] ?? null;
            $depends_on_formatted = str_replace('_', '.', $depends_on);

            if (isset($question['type']) && $question['type'] === "text") {
                $response = collect($this->responses)->firstWhere('id', $depends_on_formatted)['response'] ?? null;

                if (isset($response) && $response == 'yes') {
                    $question['question'] = str_replace('(must be over 1M ohm)', '(must be over 10K ohm)', $question['question']);
                }
            } else {
                $filtered_values = array_map(
                    fn ($response) => $response['response'],
                    array_filter(
                        $this->responses,
                        fn ($response) => isset($response['id']) && $response['id'] === $depends_on_formatted
                    )
                );

                $question['depends_on_options'] = $filtered_values;
                if (isset($filtered_values) && count($filtered_values) < 1) {
                    $this->error = 'This step depends on step ' . $depends_on_formatted . ' and no description about sub-main has been provided previously';
                }
            }
        }

        return $question;
    }

    private function get_next_step($question, $response)
    {
        return $question['next'][$response] ?? null;
    }

    private function reset_properties()
    {
        $this->response = '';
        $this->error = '';
        $this->response_prompt = '';
        $this->show_prompt = false;
    }

    public function restart_test()
    {
        $this->current_section_index = 0;
        $this->current_question_index = 0;
        $this->responses = [];
        $this->response = '';
        $this->error = '';
        $this->response_prompt = '';
        $this->show_prompt = false;
    }

    public function render()
    {
        return view('livewire.test-report-certificate', [
            'section' => $this->get_current_section(),
            'question' => $this->get_current_question(),
            'responses' => $this->responses,
        ]);
    }
}
