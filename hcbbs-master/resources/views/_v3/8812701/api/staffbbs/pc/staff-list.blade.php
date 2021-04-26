<div class="p-staff-container">
    @foreach ($filteredStaffData as $row)
    <a href="staff-detail.html?:000038" class="p-staff-item">
      <figure class="p-staff-item__fig" style="background-image: url('//cgi3-aws.hondanet.co.jp/cgi/8812701/staff_disp/data/image/8812701_staff_20151003204155_29081_00001.jpg');"></figure>
      <div class="p-staff-item__inner">
        <p class="p-staff-item__job"></p>
        <p class="p-staff-item__name">星野　昌之</p>
        <time class="p-staff-item__time">2020/02/27 更新</time>
        <span class="c-button is-default p-staff-item__button">Read more</span>
      </div>
    </a>
    @endforeach
</div>