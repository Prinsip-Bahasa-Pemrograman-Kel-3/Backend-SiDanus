<div>
    <h3>Majors Chart</h3>
    <ul>
        @foreach ($majors as $major)
            <li>{{ $major->name }}</li>
        @endforeach
    </ul>
</div>