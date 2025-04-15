<x-layout>
        <div class="w3-container w3-padding-32 mt-5">
            <h1 class="w3-border-bottom w3-border-light-grey w3-padding-16 mb-4">View {{ $order1->id }}</h1>
        </div>
    <div class="card text-right mb-5 w3-black">
        <div class="card-body">
            <ul>
                @foreach ($order1->getAttributes() as $key => $value)
                    <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <a class="btn btn-info" href="{{ route('order1s.edit', $order1) }}">Edit</a>
    <form action="{{ route('order1s.destroy', $order1) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
    </form>
    <a class="btn btn-dark" href="{{ route('order1s.index') }}">Back to list</a>
</x-layout>

