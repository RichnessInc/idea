<div>
    <ul class="text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200">
        @foreach($rows as $row)
        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 flex items-center justify-between">
            <p>{!! $row->content !!}</p>
            <p>{{date('d-m-Y / h:i A', strtotime($row->created_at))}}</p>
        </li>
        @endforeach
    </ul>
</div>
