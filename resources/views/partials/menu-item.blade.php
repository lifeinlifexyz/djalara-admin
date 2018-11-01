@if (isset($item['is_header']) && $item['is_header'])
    <li class="header">{{ $item['name'] }}</li>
@else
    <li>
        <a href="{{$item['url']}}">
            {{ $item['name']  }}
        </a>
    </li>
@endif

@if (isset($item['items']) && is_array($item['items']))
    @each('djalara-admin::partials.menu-item', $item['items'], 'item')
@endif