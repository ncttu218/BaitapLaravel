@foreach ($ranking as $i => $item)
<a href="staff-detail.html?:{{ $item['staff_code'] }}" class="p-staff-ranking-item">
   <i class="p-staff-ranking-item__number"><span>{{ $i + 1 }}</span>位</i>
   <figure class="p-staff-ranking-item__fig" style="background-image: url('{{ asset_auto($item['staff_photo2']) }}');"></figure>
   <div class="p-staff-ranking-item__inner">
      <p class="p-staff-ranking-item__name">{{ $item['staff_name'] }}</p>
      <p class="p-staff-ranking-item__info">
         <span class="p-staff-ranking-item__shop">{{ $item['shop_name'] }}</span>
         <span class="p-staff-ranking-item__job">{{ $item['staff_position'] }}</span>
      </p>
      <span class="c-button is-primary p-staff-ranking-item__button">Read more</span>
   </div>
</a>
@endforeach