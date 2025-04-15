<x-layout>
    <div class="w3-container w3-padding-32 mt-5">
        <h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">
            {{ ucfirst('projects') }}
        </h1>
    </div>

    <form method="GET" action="{{ route('projects.index') }}" class="mb-3">
        <div class="row">
            @foreach ($fields as $field)
                <div class="col-md-3 mb-2">
                    @if(Str::startsWith($field['type'], 'enum'))
                            @php
                                $options = explode(',', Str::between($field['type'], 'enum(', ')'));
                            @endphp
                            <div class="d-flex">
                            <label class="form-label me-1" for="{{ $field['name'] }}">{{ ucfirst($field['name']) }}:</label>
                                @foreach($options as $option)
                                    <div class="form-check">
                                        <input type="radio" name="{{ $field['name'] }}" value="{{ trim($option) }}"
                                            class="form-check-input" id="{{ $field['name'] }}_{{ trim($option) }}"
                                            {{ old($field['name']) == trim($option) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $field['name'] }}_{{ trim($option) }}">{{ ucfirst(trim($option)) }}</label>
                                    </div>
                                @endforeach
                            </div>
                    @else
                        <input
                            type="text"
                            name="{{ $field['name'] }}"
                            class="form-control"
                            value="{{ request($field['name']) }}"
                            placeholder="Filter by {{ ucfirst($field['name']) }}"
                        >
                    @endif
                </div>

            @endforeach
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </div>
    </form>

    <a class="btn btn-primary mb-3" href="{{ route('projects.create') }}">Create New</a>

    <table class="table table-dark">
        <thead>
            <tr>
                @foreach ($fields as $field)
                    <th class="text-center">{{ ucfirst($field['name']) }}</th>
                @endforeach
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    @foreach ($fields as $field)
                        <td class="text-center">{{ $project[$field['name']] }}</td>
                    @endforeach
                    <td class="text-center">
                        <a class="btn btn-info" href="{{ route('projects.edit', $project) }}">Edit</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        <a class="btn btn-warning" href="{{ route('projects.show', $project) }}">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>