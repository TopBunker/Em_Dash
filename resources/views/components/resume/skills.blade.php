@props(['params'])
<div>
    <h1>Skills and Competencies</h1>
    <hr class="mb-4">
    <div class="flex flex-col justify-between space-y-4">
        @if (empty($categories))
        @foreach (current($skills) as $skill => $entry)
        <p>{{$entry}}</p>
        @endforeach
        @else
        @foreach ($categories as $cat)
        <div class="flex flex-col">
            <h3 class="block">{{$cat}}</h3>
            @foreach ($skills[$cat] as $skill)
            <p>{{$skill}}</p>
            @endforeach
        </div>
        @endforeach
        @endif
    </div>
</div>