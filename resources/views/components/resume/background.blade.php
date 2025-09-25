@props(['params'])
<div class="flex flex-col">
    <h1>Background</h1>
    <hr class="mb-4">
    <div class="flex flex-col mb-8">
        <h2>Summary</h2>
        <p>{{$summary}}</p>
    </div>
    <h2>Education</h2>
    @foreach ($educations as $education)
    <div class="grid grid-cols-2 gap-y-1 md:grid-cols-[minmax(auto,400px)_auto]">
        <h3>DATES</h3>
        <p>{{$education['start_date']}} - {{$education['end_date'] ? $education['end_date'] : 'present'}}</p>
        <h3>QUALIFICATION AWARDED</h3>
        <p>{{$education['degree']}}</p>
        <h3>PRINCIPAL STUDIES</h3>
        <p>{{$education['edu_detail']['detail']}}</p>
        <h3>INSTITUTION</h3>
        <p>{{$education['institution']}}</p>
    </div>
    @endforeach
</div>