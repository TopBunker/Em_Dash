@props(['params'])
<div>
    <h1>Skills and Competencies</h1>
    <hr>
    <div class="flex flex-col justify-between">
        @foreach ($categories as $cat)
        <div class="flex flex-col">
            <h3 class="block">{{$cat}}</h3>
            @foreach ($skills[$cat] as $skill)
            <p>{{$skill}}</p>
            @endforeach
        </div>
        @endforeach
    </div>
</div>