@section('title','admin')
@extends('master')
@section('noidung')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Số tiền còn lại của user theo các level</h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('get-sotiencuausertheolevel') }}" method="GET" class="mb-5" id="filter-frm">
                    <div class="row">
                        <div class="col-sm-3" style="height:85px">
                            <div class="form-group input-group-sm">
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="time" id="time-1" onchange="changeRadio('week')"
                                           value="week" {{$input['time'] == 'week' || empty($input['time']) ? 'checked' : ''}}>&nbsp;Theo
                                    tuần
                                </label>
                                <input type="week" name="week" class="form-control" id="week"
                                       value="{{!empty($input['week']) ? $input['week'] : ''}}">
                            </div>
                        </div>
                        <div class="col-sm-3" style="height:85px">
                            <div class="form-group input-group-sm">
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="time" id="time-2" onchange="changeRadio('month')"
                                           {{$input['time'] == 'month' && !empty($input['time']) ? 'checked' : ''}}
                                           value="month">&nbsp;Theo tháng
                                </label>
                                <input type="month" name="month" class="form-control" id="month"
                                       value="{{!empty($input['month']) ? $input['month'] : ''}}">
                            </div>
                        </div>
                        <div class="col-sm-3" style="height:85px;">
                            <div class="form-group input-group-sm">
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="time" id="time-3" onchange="changeRadio('tuychon')"
                                           {{$input['time'] == 'tuychon' && !empty($input['time']) ? 'checked' : ''}}
                                           value="tuychon">&nbsp;Tuỳ chọn
                                </label>
                                <input type="date" name="from-date" class="form-control" id="from-date" title="Từ ngày"
                                       value="{{!empty($input['from-date']) ? $input['from-date'] : ''}}">
                                <input type="date" name="to-date" class="form-control" id="to-date" title="Đến ngày"
                                       value="{{!empty($input['to-date']) ? $input['to-date'] : ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <input type="submit" onclick="clickSubmit()" class="btn btn-primary" id="btnsubmit"
                               value="Filter">
                    </div>
                </form>

                <div class="row" id="divbang">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable">
                            <thead>
                            <tr>
                                <th>Deviceid</th>
                                <th>Level</th>
                                <th>Coin</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(!empty($logpagi))
                                @foreach($logpagi as $key => $item)
                                    <tr>
                                        <td>{{$item->deviceid}}</td>
                                        <td>{{$item->level}}</td>
                                        <td>{{$item->c_coin}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div style="float: right">
                            @if(!empty($logpagi))
                                {!!  $logpagi->appends(request()->except(['page','_token']))->links("pagination::bootstrap-4")  !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>

    <!-- Page level plugins -->
    <script>

        $(function () {
            changeRadio('{{empty($input['time']) ? 'week' : $input['time']}}');
        });

        function changeRadio(time) {
            if (time == 'week') {
                $('#week').removeAttr('disabled');

                $('#month').attr('disabled', 'disabled');
                $('#from-date').attr('disabled', 'disabled');
                $('#to-date').attr('disabled', 'disabled');
            } else if (time == 'month') {
                $('#month').removeAttr('disabled');

                $('#week').attr('disabled', 'disabled');
                $('#from-date').attr('disabled', 'disabled');
                $('#to-date').attr('disabled', 'disabled');
            } else if (time == 'tuychon') {
                $('#month').attr('disabled', 'disabled');
                $('#week').attr('disabled', 'disabled');

                $('#from-date').removeAttr('disabled');
                $('#to-date').removeAttr('disabled');
            }
        }

        function clickSubmit() {
            event.preventDefault();

            if ($('#time-1').is(':checked') === true && $('#week').val() == '') {
                makeAlertright('Vui lòng chọn Tuần.', 3000);
                return;
            }

            if ($('#time-2').is(':checked') === true && $('#month').val() == '') {
                makeAlertright('Vui lòng chọn Tháng.', 3000);
                return;
            }

            if ($('#time-3').is(':checked') === true && ($('#from-date').val() == '' || $('#to-date').val() == '')) {
                makeAlertright('Vui lòng chọn Từ ngày/Đến ngày.', 3000);
                return;
            }

            $('#btnsubmit').attr('disabled', 'disabled');
            $('#divbang').html("<div class='loader'></div>");

            $('#filter-frm').submit();
        }


        function makeAlertright(msg, duration) {
            var el = document.createElement("div");
            el.setAttribute("style", "position:fixed;bottom:2%;right:2%; width:25%;z-index:999999");
            el.innerHTML = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-times"></i> <strong>Error!! </strong>' + msg + '</div>';
            setTimeout(function () {
                el.parentNode.removeChild(el);
            }, duration);
            document.body.appendChild(el);
        }

    </script>

@endsection