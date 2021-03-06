<!DOCTYPE html>
<html lang="en">
@include('emails.header')
<body style="margin: 0; padding: 0;">

  <!-- HEADER -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td bgcolor="#2c5687">
        <div align="center" style="padding: 0px 15px 0px 15px;">
          <table border="0" cellpadding="0" cellspacing="0" width="500" class="wrapper">
            <!-- LOGO/PREHEADER TEXT -->
            <tr>
              <td style="padding: 20px 0px 20px 0px;" class="logo">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td bgcolor="#2c5687" width="100" align="left"><a href="http://www.easydockapp.com" target="_blank">
                      <img alt="Logo" src="http://www.easydockapp.com/img/logo-sm.png" width="72" height="72" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px;" border="0"></a>
                    </td>
                    <td bgcolor="#2c5687" width="400" align="right" class="mobile-hide">
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="right" style="padding: 0 0 5px 0; font-size: 18px; font-family: Arial, sans-serif; color: #ffffff; text-decoration: none;">
                            <span style="color: #ffffff; text-decoration: none;">EasyDock<br><span style="font-size: 12px;">Book the dock you need wherever you are</span></span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

  <!-- ONE COLUMN SECTION -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td bgcolor="#ffffff" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding">
        <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
          <tr>
            <td>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <!-- HERO IMAGE -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td class="padding-copy">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>
                                  <img src="http://www.easydockapp.com/img/booking.png" width="250" height="250" border="0" alt="Booking" style="display: block; padding:0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px; width: 250px; height: 250px;margin-left:auto;margin-right:auto" class="img-max">
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <!-- COPY -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">
                          {{ $title }}
                        </td>
                      </tr>
                      <tr>
                        <td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                          <span>{{ $intro }} </span>
                        </td>
                      </tr>
                      @if ($id != '')
                      <tr>
                        <td align="center" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #666666; padding-top: 10px;" class="padding-copy">
                          <table border="0" cellspacing="5" cellpadding="5">
                            <tr>
                              <td><strong>Id</strong></td>
                              <td>{{ $id }}</td>
                            </tr>
                            <tr>
                              <td><strong>{{trans('models.fields.from')}}</strong></td>
                              <td>{{ $date_start }}</td>
                            </tr>
                            <tr>
                              <td><strong>{{trans('models.fields.until')}}</strong></td>
                              <td>{{ $date_end }}</td>
                            </tr>
                            <tr>
                              <td><strong>{{trans('models.port')}}</strong></td>
                              <td>{{ $port }}</td>
                            </tr>
                          </table>
                        <td>
                      </tr>
                      @if ($action == 'update')
                      <tr>
                        <td align="center">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                            <tr>
                              <td align="center" style="padding: 0;" class="padding-copy">
                                <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                                  <tr>
                                    @if ($confirmed)
                                      <td align="center"><p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #18bc9c; border-top: 2px solid #18bc9c; border-bottom: 2px solid #18bc9c; border-left: 2px solid #18bc9c; border-right: 2px solid #18bc9c; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block; padding:3px;" class="mobile-button">{{trans('messages.confirmed')}}</p></td>
                                    @else
                                      <td align="center"><p style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #e74c3c; border-top: 2px solid #e74c3c; border-bottom: 2px solid #e74c3c; border-left: 2px solid #e74c3c; border-right: 2px solid #e74c3c; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block; padding:3px;" class="mobile-button">{{trans('messages.canceled')}}</p></td>
                                    @endif
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      @endif
                      @endif
                      <tr>
                        <td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                          {{ $text }}
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                @if ($url != '')
                <tr>
                  <td>
                    <!-- BULLETPROOF BUTTON -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                      <tr>
                        <td align="center" style="padding: 25px 0 0 0;" class="padding-copy">
                          <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                            <tr>
                              <td align="center">
                                <a href="{{ $url }}" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #2c5687; border-top: 15px solid #2c5687; border-bottom: 15px solid #2c5687; border-left: 25px solid #2c5687; border-right: 25px solid #2c5687; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">{{ $button }} &rarr;</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                @endif
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- FOOTER -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td bgcolor="#ffffff" align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td style="padding: 20px 0px 20px 0px;">
              <!-- UNSUBSCRIBE COPY -->
              <table width="500" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">
                <tr>
                  <td align="center" valign="middle" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                    <a class="original-only" style="color: #666666; text-decoration: none;">EasyDock</a><span class="original-only" style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span><a href="" style="color: #666666; text-decoration: none;">http://www.easydockapp.com</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</body>
</html>
