<div>
    <h3>Departments Chart</h3>
    <ul>
        @foreach ($departments as $department)
            <li>{{ $department->name }}</li>
        @endforeach
    </ul>
</div>