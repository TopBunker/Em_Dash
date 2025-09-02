@props(['params'])
<div class="flex flex-col justify-around">
    @if (count($experiences) > 0)
    <h1>Experience</h1>
    <hr>
    @foreach ($experiences as $experience)
    <div class="grid grid-cols-2">
        <h3>DATES</h3>
        <p>{{$experience['start_date']}} - {{$experience['end_date']}}</p>
        <h3>POSITION</h3>
        <p>{{$experience['position']}}</p>
        <h3>EMPLOYER</h3>
        <p>{{$experience['employer']}}</p>
        <h3>BUSINESS TYPE</h3>
        <p>{{$experience['business_type']}}</p>
        <h3>Tasks & Achievements</h3>
        <div class="col-span-2 flex flex-col sm:grid sm:grid-cols-2">
            {{ $nulCheck = false }}
            @if (count($headings)>0)
            @foreach ($headings as $key)
            {{ $nullCheck = $key===null ? true : false;}}
            @if ($key !== null)
            <div class="flex flex-col">
                <p class="font-bold text-center">{{$key}}</p>
                <ul class="list-none">
                    @foreach ($experience['tasks'] as $task)
                    @if ($task['heading'] === $key)
                    <x-bullet type=0 :item="$task['task']" />
                    @endif
                    @endforeach
                    @foreach ($experience['accomplishments'] as $accomplishment)
                    @if ($accomplishment['heading'] === $key)
                    <x-bullet type=1 :item="$accomplishment['accomplishment']" />
                    @endif
                    @endforeach
                </ul>
            </div>
            @endif
            @endforeach
            @if ((count($headings) > 1) && $nullCheck)
            <div class="col-span-2 flex flex-col">
                <p class="font-bold text-center">Other</p>
                <ul class="list-none">
                    @foreach ($experience['tasks'] as $task)
                    @php
                        dd($task);
                    @endphp
                    @if ($task['heading'] === null)
                    <x-bullet type=0 :item="$task['task']" />
                    @endif
                    @endforeach
                    @foreach ($experience['accomplishments'] as $accomplishment)
                    @if ($accomplishment['headings'] === null)
                    <x-bullet type=1 :item="$accomplishment['accompolishment']" />
                    @endif
                    @endforeach
                </ul>
            </div>
            @endif
            @endif
            @if ((count($headings) === 1) && (current($headings) === null))
            <div class="col-span-2 flex flex-col">
                <ul>
                    @foreach ($experience['tasks'] as $task)
                    <x-bullet type=0 :item="$task['task']" />
                    @endforeach
                    @foreach ($experience['accomplishments'] as $accomplishment)
                    <x-bullet type=1 :item="$accomplishment['accomplishment']" />
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    @endforeach
    @endif
</div>