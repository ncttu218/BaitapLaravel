<section class="c-section-container _both-space">
  <div class="c-section-inner">
    <article class="p-staff-profile">
      <header class="p-staff-profile__header">
        <h2 class="p-staff-profile__name">{{ $staff->name }}</h2>
        <h3 class="p-staff-profile__info"></h3>
      </header>
      <div class="p-staff-profile__inner">
        <figure class="p-staff-profile__image" style="background-image: url('{{ asset_auto($staff->photo2) }}');"></figure>
        <div class="p-staff-profile__detail">
          @if (isset($staff->qualification))
          <div class="p-staff-profile__birth">            
              <h3>資格</h3>            
              <p>{!! nl2br($staff->qualification) !!}</p>          
          </div>
          @endif
          @if (isset($staff->hobby))
          <div class="p-staff-profile__birth">            
              <h3>趣味</h3>            
              <p>{!! nl2br($staff->hobby) !!}</p>          
          </div>
          @endif
          @foreach ($staff->extra as $key => $value)
            @if (is_array($value))
              @foreach ($value as $svalue)
                <div class="p-staff-profile__birth">            
                    <h3>{{ $key }}</h3>            
                    <p>{{ $svalue }}</p>          
                </div>
              @endforeach
            @else
              <div class="p-staff-profile__birth">            
                  <h3>{{ $key }}</h3>            
                  <p>{!! nl2br($value) !!}</p>          
              </div>
            @endif
          @endforeach
        </div>
      </div>
      <div class="p-staff-profile__message">
        <h3>Message</h3>
        <p>{!! nl2br($staff->message) !!}</p>
      </div>
    </article>
  </div>
</section>