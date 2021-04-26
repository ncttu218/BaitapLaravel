<div class="sr_blog">
@foreach ($items as $item)
<article>
   <div class="blog__header">
      <p class="blog__title">{{ $item['title'] }}</p>
      <p class="blog__date">{{ $item['time'] }}</p>
   </div>
   <div class="blog__body">
      <div style="float:left">
         {!! $item['content'] !!}
         <table border="0" cellspacing="0" cellpadding="1">
            <tbody>
               <tr valign="bottom">
                  <td bgcolor="#FFFFFF"><font style="font-size:10px;"></font></td>
                  <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                     </font>
                  </td>
                  <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                     </font>
                  </td>
               </tr>
               <tr align="left">
                  <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                     </font>
                  </td>
                  <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                     </font>
                  </td>
                  <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                     </font>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <div style="float:left">
         <font style="font-size:10px;">   
         </font> 
      </div>
      <div style="clear:both;">
      </div>
   </div>
</article>
@endforeach

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

</div>