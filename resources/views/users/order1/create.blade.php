<x-layout>
      <div class="w3-container w3-padding-32 mt-5">
            <h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Create {{ $modelVariable }}</h1>
        </div>
    <div class="card w3-black">
        <div class="card-body">
            <form action="{{ route('order1s.store') }}" method="POST">
                @csrf

                @foreach ($fields as $field)
                    <div class="form-group">
                        <label class="form-label" for="{{ $field['name'] }}">{{ ucfirst($field['name']) }}</label>

                        @if(Str::startsWith($field['type'], 'enum'))
                            @php
                                $options = explode(',', Str::between($field['type'], 'enum(', ')'));
                            @endphp
                            @foreach($options as $option)
                                <div class="form-check">
                                    <input type="radio" name="{{ $field['name'] }}" value="{{ trim($option) }}"
                                        class="form-check-input" id="{{ $field['name'] }}_{{ trim($option) }}"
                                        {{ old($field['name']) == trim($option) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $field['name'] }}_{{ trim($option) }}">{{ ucfirst(trim($option)) }}</label>
                                </div>
                            @endforeach
                        @else
                            <input type="text" class="form-control" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ old($field['name']) }}">
                        @endif

                        @error($field['name'])
                            <div><p class="text-danger">{{ $message }}</p></div>
                        @enderror
                    </div>
                @endforeach

                <button class="btn btn-success mt-2" type="submit">Save</button>
            </form>
        </div>
    </div>
</x-layout>
