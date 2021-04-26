@foreach ($filteredStaffData as $row)
    <a href="staff-detail.html?:{{ $row->staff_code }}" class="p-staff-item">
        <figure class="p-staff-item__fig" style="background-image: url('{{ asset_auto($row->photo2) }}');"></figure>
        <div class="p-staff-item__inner">
            <p class="p-staff-item__job"></p>
            <p class="p-staff-item__name">{{ $row->name }}</p>
            <time class="p-staff-item__time">
                @if (isset($row->blog_updated_at))
                    {{ date('Y/m/d',strtotime($row->blog_updated_at)) }} 更新
                @endif
            </time>
            <span class="c-button is-default p-staff-item__button">Read more</span>
        </div>
    </a>
@endforeach