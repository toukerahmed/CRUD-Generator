<x-layout>
      <div class="w3-container w3-padding-32 mt-5">
            <h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">{{ ucfirst('orders') }}</h1>
        </div>

    <a class="btn btn-primary mb-3" href="{{ route('orders.create') }}">Create New</a>

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
            @foreach ($orders as $order)
                <tr>
                    @foreach($fields as $field)
                        <td class="text-center">{{ $order[$field['name']] }}</td>
                    @endforeach
                    <td class="text-center">
                        <a class="btn btn-info" href="{{ route('orders.edit', $order) }}">Edit</a>
                        <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        <a class="btn btn-warning" href="{{ route('orders.show', $order) }}">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
