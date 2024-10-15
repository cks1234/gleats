<div>
    <h3 class="mb-3">{{ $section['title'] }}</h3>
    <div class="d-flex gap-2">
        <p class="mb-3">{{ $question['question'] }}</p>
        @if (!isset($question['nullable']) || $question['nullable'] === false)
            <span class="text-danger">*</span>
        @endif
    </div>

    <div class="mb-3">
        @if (!$show_prompt)
            @switch($question['type'])
                @case('yes_no')
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="response" value="yes" wire:model="response"
                            id="yesOption">
                        <label class="form-check-label" for="yesOption">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="response" value="no" wire:model="response"
                            id="noOption">
                        <label class="form-check-label" for="noOption">No</label>
                    </div>
                @break

                @case('select')
                    <div>
                        <select class="form-select" wire:model="response">
                            <option value="">Select Option</option>
                            @foreach ($question['options'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                @break

                @case('dropdown')
                    <div>
                        <select class="form-select" wire:model="response">
                            <option value="">Select Option</option>
                            @foreach ($question['depends_on_options'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                @break

                @case('float')
                    <input type="number" step="0.01" class="form-control" wire:model="response">
                @break

                @case('int')
                    <input type="number" step="1" class="form-control" wire:model="response">
                @break

                @case('text')
                    <input type="text" class="form-control" wire:model="response">
                @break
            @endswitch
        @else
            <div class="d-flex gap-2">
                <p>{{ $prompt_current['text'] ?? '' }}</p>
                <span class="text-danger">*</span>
            </div>

            @switch($prompt_current['type'])
                @case('text')
                    <input type="text" class="form-control" wire:model="response_prompt">
                @break

                @case('float')
                    <input type="number" step="0.01" class="form-control" wire:model="response_prompt">
                @break
            @endswitch

            <button class="btn btn-primary mt-3" wire:click="submit_prompt">Next</button>
        @endif
    </div>

    @if ($error)
        <p class="text-danger">{{ $error }}</p>
    @endif

    @if (!$show_prompt)
        <button class="btn btn-primary" wire:click="handle_next">Next</button>
    @endif

    <div class="mt-3">
        <button class="btn btn-warning" wire:click="restart_test">
            Restart Test
        </button>
    </div>

    @if ($responses)
        <div class="form-group mt-3">
            <h3 class="mb-3">Responses</h3>
            @foreach ($responses as $response)
                <div class="row">
                    <label><strong>{{ $response['question'] }}</strong></label>
                    <p>
                        @if ($response['response'] == 'yes' || $response['response'] == 'no')
                            {{ ucfirst($response['response']) }}
                        @else
                            {{ $response['response'] }}
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    @endif
</div>
