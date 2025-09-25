@props(['params'])
<div>
    <h1>Skills and Competencies</h1>
    <hr class="mb-4">
    <div class="flex flex-col justify-between space-y-4">
        @if (empty($categories))
        @foreach (current($skills) as $skill => $entry)
        <div class="flex">
            <p>{{$entry}}</p>
        </div>
        @endforeach
        @else
        @foreach ($categories as $cat)
        <div class="flex flex-col">
            <h3 class="block">{{$cat}}</h3>
            @foreach ($skills[$cat] as $key => $val)
            <div class="flex">
                <p><span class="font-medium">{{ is_string($key) ? $key.':' : ''}}</span> {{ $val[0] }} {{$val[1] ? '('.$val[1].')' : ''}}</p>
            </div>
            @endforeach
        </div>
        @endforeach
        @endif
    </div>
</div>