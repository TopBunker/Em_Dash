@props(['params'])

<div>
    <h1>References</h1>
    <hr class="mb-4">
    <div class="flex flex-col space-y-4">
    @foreach ($params as $item)
    <div class="flex flex-col">
        <blockquote>{{$item['referral']}}</blockquote>
        <cite>{{$item['referee']}}</cite>
    </div>
    @endforeach
    </div>
</div>