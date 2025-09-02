@props(['params'])

<div>
    <h1>References</h1>
    <hr>
    @foreach ($params as $item)
    <div class="flex flex-col">
        <blockquote>{{$item['referral']}}</blockquote>
        <cite>{{$item['referee']}}</cite>
    </div>
    @endforeach
</div>