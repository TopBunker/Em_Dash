@props(['params'])
<div class="flex flex-col">
    <h1>Experience</h1>
    <hr class="mb-4">
    <div class="flex flex-col space-y-16">
    @foreach ($experiences as $experience)
    <div class="flex flex-col space-y-2">
        <!--Experience Header-->
        <div class="grid grid-cols-2">
            <h3>DATES</h3>
            <p>{{$experience['start_date']}} - {{$experience['end_date']}}</p>
            <h3>POSITION</h3>
            <p>{{$experience['position']}}</p>
            <h3>EMPLOYER</h3>
            <p>{{$experience['employer']}}</p>
            <h3>BUSINESS TYPE</h3>
            <p>{{$experience['business_type']}}</p>
            <!--Details--> 
            <h3>Tasks & Achievements</h3>
        </div>
        <div class="flex flex-col sm:grid sm:grid-cols-2 gap-3">
            <!--1. with headings-->
            @php
            $nullCheck = false;
            @endphp
            @if(count($headings) > 0)
            @foreach ($headings as $key => $value)
            <div class="flex flex-col">
                @php
                // Resume parent hasValue function
                $hasHeading = $this->hasValue($value, array_merge($experience['tasks'],$experience['accomplishments']));
                @endphp
                @if ($hasHeading)
                    <p class="font-bold text-center">{{$value}}</p>       
                @endif    
                <ul class="list-none">
                    @foreach ($experience['tasks'] as $task)
                    @if($task['heading'] === null)
                    @php
                    $nullCheck = true;
                    @endphp
                    @endif
                    @if ($task['heading'] === $value)
                    <x-bullet type=0 :item="$task['task']" />
                    @endif
                    @endforeach
                    @foreach ($experience['accomplishments'] as $accomplishment)
                    @if($accomplishment['heading'] === null)
                    @php
                    $nullCheck = true;
                    @endphp
                    @endif
                    @if ($accomplishment['heading'] === $value)
                    <x-bullet type=1 :item="$accomplishment['accomplishment']" />
                    @endif
                    @endforeach
                </ul>
            </div>
            @endforeach
            <!--1.1　add tasks/accomplishments without headings last-->
            @if ($nullCheck) 
            <div class="flex flex-col">
                <p class="font-bold text-center">Other</p>
                <ul class="list-none">
                    @foreach ($experience['tasks'] as $task)
                    @if ($task['heading'] === null)
                    <x-bullet type=0 :item="$task['task']" />
                    @endif
                    @endforeach
                    @foreach ($experience['accomplishments'] as $accomplishment)
                    @if ($accomplishment['heading'] === null)
                    <x-bullet type=1 :item="$accomplishment['accomplishment']" />
                    @endif
                    @endforeach
                </ul>
            </div>
            @endif 
            @endif
            <!--2. if tasks and accomplishments are not linked by headings, list all tasks then list all accomplishments-->
            @if (empty($headings)) 
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
    </div>
</div>