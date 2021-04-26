<script language="JavaScript" src="/common-js/opendcs.js"></script>
<a name="0"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
   <tr>
      <td valign="middle" align="left" colspan="2">
         <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr bgcolor="#FFFFFF">
               <form method="get" action="./grbbs3.cgi?">
               <td valign="middle" align="left"></td>
               <td valign="middle" align="right">
                    {{-- ページネーションの読み込み --}}
                    @include($templateDir . '.pagination') 
               </td>
            </tr>
         </table>
      </td>
   </tr>
   {{-- 記事データが存在するとき --}}
   @foreach ($blogs as $item)
   <tr>
      <td colspan="2">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td>
                  <table width="100%" border="0" cellspacing="1" cellpadding="0">
                     <tr>
                        <td>
                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td class="blogTitle">
                                    <b></b> 
                                    <table width="100%" border="0" cellspacing="1" cellpadding="2">
                                       <tr>
                                          <td><b>{{ $item->title }}</b> 
                                          </td>
                                          <td align="right" bgcolor="#eeeeee" nowrap><font style="font-size:10px;">【{{ $item->base_name }}】</font>&nbsp;</td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <table width="100%" border="0" cellspacing="0" cellpadding="3">
                              <tr>
                                 <td valign="top" bgcolor="#FFFFFF" align="left" class="m">
                                    <?php
                                    // 記事が改行が必要かの判定
                                    $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
                                    $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                                    ?>
                                    @if ($hasNoBr)
                                      {!! nl2br( $item->comment ) !!}
                                    @else
                                      {!! $item->comment !!}
                                    @endif
                                    
                                    @include('api.common.api.infobbs.image_list_default')
                                 </td>
                              </tr>
                              <tr>
                                 <td valign="top" bgcolor="#FFFFFF" nowrap>
                                    <table border="0" cellspacing="0" cellpadding="1">
                                       <tr valign="bottom">
                                          <td bgcolor="#FFFFFF"><font style="font-size:10px;"></font></td>
                                          <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                             </font>
                                          </td>
                                          <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                             </font>
                                          </td>
                                       </tr>
                                       <tr>
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
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  {{-- コメント --}}
                  @include($templateDir . '.comment')
               </td>
            </tr>
         </table>
      </td>
   </tr>
   @endforeach
   <!-- ZERO END -->
   <tr>
      <td align="right" colspan="2">
         <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr bgcolor="#000066">
               <td valign="middle" align="left" colspan="2" bgcolor="#FFFFFF">
                  <hr size="1" noshade color="#cccccc">
               </td>
            </tr>
            <tr bgcolor="#FFFFFF">
               <td valign="middle" align="left"></td>
               <td valign="middle" align="right">
                    {{-- ページネーションの読み込み --}}
                    @include($templateDir . '.pagination')
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>