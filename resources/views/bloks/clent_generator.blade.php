<div class="content-files__wrap">
    <form method="post" action="{{route('client_generator')}}" id="form_client_generator" onsubmit="getUoClient();return false;" class="content-market__search-left">
        {{csrf_field()}}
        <table>
            <tbody>
                <tr><td colspan="2">{{trans("client_generator.nastroyki_grafiki")}}:</td></tr>

                <tr>
                    <td><input type="radio" name="client" value="1" id="client-1" checked="yes"></td>
                    <td><label style="font-weight: 300;" for="client-1">{{trans("client_generator.uvelichennaya_oblast_otrisovki_karty_rekomenduetsya")}}</label></td>
                </tr>

                <tr>
                    <td><input type="radio" name="client" value="2" id="client-2"></td>
                    <td><label style="font-weight: 300;" for="client-2">{{trans("client_generator.uvelichennaya_oblast_otrisovki_karty_i_statiki_vysokoe_resursopotreblenie")}}</label></td>
                </tr>

                <tr>
                    <td><input type="radio" name="client" id="client-3" value="3"></td>
                    <td><label style="font-weight: 300;" for="client-3">{{trans("client_generator.standartnyy_klient_esli_u_vas_slabyy_protsessor")}}</label></td>
                </tr>

                <tr>
                    <td><input type="checkbox" name="removeCrypt" id="removeCrypt" checked="checked"></td>
                    <td><label style="font-weight: 300;" for="removeCrypt">{{trans("client_generator.ubrat_shifrovanie")}}</label></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="xsize" style="width: 95%;margin-left: 21px;margin-top: 10px;">{{trans("client_generator.razmer_igrovogo_okna")}}:</label>
                        <div class="form-group content-market__search" style="width: 95%;margin: auto;margin-bottom: 20px;">
                            <div class="input-wrap">
                                <input type="text" name="xsize" id="xsize" value="640" size="4" maxlength="4" class="form-control my-form-custom" style="float: left;width: 100px;">
                                <input type="text" value="x" disabled class="form-control my-form-custom" style="width: 28px;float: left;">
                                <input type="text" name="ysize" id="ysize" value="480" size="4" maxlength="4" class="form-control my-form-custom" style="float: left;width: 100px;">
                                <div class="content-market__search-btn" style="float: left;margin-top: -3px;">
                                    <button type="submit">{{trans("client_generator.skachat")}}</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr id="clientMsg" style="visibility: hidden;">
                    <td colspan="2">
                        <div style="color:#ff0000;">
                            {{trans("client_generator.razmer_okna_dolzhen_byt_v_diapazone")}}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

@push('scripts')
<script>
    function getUoClient()
    {
        var intRegex = /^\d+$/;
        var xsize = $("#xsize").val();
        var ysize = $("#ysize").val();
        if(intRegex.test(xsize) && intRegex.test(ysize) &&
            parseInt(xsize) >= 640 && parseInt(xsize) <= 4000 &&
            parseInt(ysize) >= 480 && parseInt(ysize) <= 4000) {
            $("#clientMsg").css("visibility", "hidden");
            $('#form_client_generator').submit();
        } else {
            $("#clientMsg").css("visibility", "visible");
        }
    }
</script>
@endpush