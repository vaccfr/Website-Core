@extends('layouts.app')

@section('page-title')
  Pilot Mentoring | My students
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/staff/pilot_mine.header_title')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="{{ asset('dashboard/stepbar.css') }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="info-box elevation-3">
          <span class="info-box-icon bg-warning"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{__('app/staff/pilot_mine.pill_one')}}</span>
            <span class="info-box-number">{{ $studentCount }}</span>
          </div>
        </div>
        <div class="card card-dark elevation-3">
          <div class="card-header">
            <h3 class="card-title">{{__('app/staff/pilot_mine.toolbox_title')}}</h3>
          </div>
          <div class="card-body p-0">
            <table class="table">
              <thead>
              </thead>
              <tbody>
                <tr>
                  <td><a href="#" target="_blank" rel="noopener noreferrer">Coming Soon!</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
        <script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
        <script src="{{ asset('dashboard/adminlte/dist/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dashboard/adminlte/dist/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        @foreach ($students as $s)
          <div class="card card-outline @if(true) card-success @else card-danger @endif elevation-3">
            <div class="card-header" data-card-widget="collapse">
              <h3 class="card-title">{{ $s['user']['fname'] }} {{ $s['user']['lname'] }} ({{ $s['user']['vatsim_id'] }}) - P{{ $s['user']['pilot_rating'] }} - {{ $s['mentoringRequest']['training_type'] }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              @if ($s['mentoringRequest']['mail_consent'] == true)
              <div class="row">
                <div class="col-md-12">
                  <i>{{__('app/staff/pilot_mine.email_share', ['FNAME' => $s['user']['fname']])}} <a href="mailto:
                    @if (is_null($s['user']['custom_email'])) 
                      {{ $s['user']['email'] }} 
                    @else 
                      {{ $s['user']['custom_email'] }} 
                    @endif">
                    @if (is_null($s['user']['custom_email'])) 
                      {{ $s['user']['email'] }} 
                    @else 
                      {{ $s['user']['custom_email'] }} 
                    @endif</a></i>
                </div>
              </div>
              @endif
              <div class="row mt-3">
                <div class="col-md-12">
                  <h4>{{__('app/staff/pilot_mine.c_progress', ['FNAME' => $s['user']['fname']])}}</h4>
                  <div class="steps">
                    <ul class="steps-container">
                      @foreach ($steps as $step)
                      @php
                        $progCurrent = $s['progress'] * $progSteps;
                        $now = ($loop->index + 1)*$progSteps;
                        if ($now > $progCurrent) {
                          $now = false;
                        } else {
                          $now = true;
                        }
                      @endphp
                      <li style="width:{{ $progSteps }}%;" @if ($now) class="activated" @endif>
                        <div class="step">
                          <div class="step-image"><span></span></div>
                          <div class="step-current">{{ $step['type'] }}</div>
                          <div class="step-description">{{ $step['title'] }}</div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                    <div class="step-bar" style="width: {{ $progCurrent }}%;"></div>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <h4>{{__('app/staff/pilot_mine.c_sessions')}}</h4>
                  <table
                    id="upcoming_sessions_{{ $s['user']['vatsim_id'] }}"
                    class="table table-bordered table-hover"
                    data-order='[[ 1, "desc" ]]'>
                    <thead>
                    <tr>
                      <th>Details</th>
                      <th>{{__('app/staff/pilot_mine.when')}}</th>
                      <th>{{__('app/staff/pilot_mine.sched_by')}}</th>
                      <th>{{__('app/staff/pilot_mine.mentor_comm')}}</th>
                      <th>{{__('app/staff/pilot_mine.student_comm')}}</th>
                      <th>{{__('app/staff/pilot_mine.status')}}</th>
                      <th>{{__('app/staff/pilot_mine.options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($s['sessions'] as $training)
                        <tr>
                          <td><button type="button" class="btn btn-flat btn-info" data-toggle="modal" data-target="#session_details_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}"><i class="far fa-eye"></i></button></td>
                          <td>{{ $training['date'] }} {{ $training['time'] }}</td>
                          <td>{{ $training['requested_by'] }}</td>
                          <td>
                            @if (!is_null($training['mentor_comment']))
                            <button type="button" class="btn btn-flat btn-info" data-toggle="modal" data-target="#mentor_comment_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}"><i class="far fa-eye"></i></button>
                            @else
                              {{__('app/staff/pilot_mine.no_comment')}}
                            @endif
                          </td>
                          <td>
                            @if (!is_null($training['student_comment']))
                            <button type="button" class="btn btn-flat btn-info" data-toggle="modal" data-target="#student_comment_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}"><i class="far fa-eye"></i></button>
                            @else
                              {{__('app/staff/pilot_mine.no_comment')}}
                            @endif
                          </td>
                          <td>{{ $training['status'] }}</td>
                          <td>
                            @if ($training['accepted_by_mentor'] == true && $training['accepted_by_student'] == false)

                              {{-- Only accepted by mentor --}}
                              <button type="button" class="btn btn-block btn-danger btn-flat" data-toggle="modal" data-target="#cancel-session-{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}"><i class="fa fa-times"></i></button>

                            @else

                              @if ($training['accepted_by_mentor'] == false && $training['accepted_by_student'] == true)

                                {{-- Only accepted by student --}}
                                <form action="{{ route('app.staff.pilot.mine.acceptsession', app()->getLocale()) }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="sessionid" value="{{ $training['id'] }}">
                                  <button type="submit" class="btn btn-block btn-success btn-flat"><i class="fa fa-check"></i></button>
                                </form>
                                <button type="button" class="btn btn-block btn-danger btn-flat" data-toggle="modal" data-target="#cancel-session-{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}"><i class="fa fa-times"></i></button>

                              @else

                                @if ($training['accepted_by_mentor'] == true && $training['accepted_by_student'] == true && $training['completed'] == false)

                                  {{-- Training accepted by both --}}
                                  <form action="{{ route('app.staff.pilot.mine.completesession', app()->getLocale()) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sessionid" value="{{ $training['id'] }}">
                                    <button type="submit" class="btn btn-block btn-success btn-flat">{{__('app/staff/pilot_mine.complete')}}</button>
                                  </form>
                                  <button type="button" class="btn btn-block btn-danger btn-flat" data-toggle="modal" data-target="#cancel-session-{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}"><i class="fa fa-times"></i></button>

                                @else

                                 @if ($training['accepted_by_mentor'] == true && $training['accepted_by_student'] == true && $training['completed'] == true)

                                  @if (is_null($training['mentor_report']))

                                    {{-- Training completed, awaiting report --}}
                                    <button type="button" class="btn btn-block btn-info btn-flat" data-toggle="modal" data-target="#add-report-{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}"><i class="fa fa-edit"></i></button>

                                  @else

                                    {{-- Training completed, has report --}}
                                    <button type="button" class="btn btn-block btn-info btn-flat" data-toggle="modal" data-target="#mentor_report_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}">{{__('app/staff/pilot_mine.see_report')}}</button>

                                  @endif
                                 @endif
                                @endif
                              @endif
                            @endif
                          </td>
                        </tr>
                        <div class="modal fade" id="session_details_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">{{__('app/staff/pilot_mine.sess_details')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>{!! nl2br($training['description']) !!}</p>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/pilot/pilot_training_center.close')}}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @if (!is_null($training['mentor_comment']))
                        <div class="modal fade" id="mentor_comment_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">{{__('app/staff/pilot_mine.mentor_comm')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>{{ $training['mentor_comment'] }}</p>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.close')}}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                        @if (!is_null($training['student_comment']))
                        <div class="modal fade" id="student_comment_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">{{__('app/staff/pilot_mine.student_comm')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>{{ $training['student_comment'] }}</p>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.close')}}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                        @if (!is_null($training['mentor_report']))
                        <div class="modal fade" id="mentor_report_{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">{{__('app/staff/pilot_mine.mentor_report')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>{{ $training['mentor_report'] }}</p>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.close')}}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                        <div class="modal fade" id="cancel-session-{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">{{__('app/staff/pilot_mine.cancel_sess')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('app.staff.pilot.mine.cancelsession', app()->getLocale()) }}" method="post">
                                @csrf
                                <div class="modal-body">
                                  <p>{{__('app/staff/pilot_mine.cancel_sess_sure')}}</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <input type="hidden" name="sessionid" value="{{ $training['id'] }}">
                                  <button type="submit" class="btn btn-danger">{{__('app/staff/pilot_mine.confirm')}}</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.cancel')}}</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <div class="modal fade" id="add-report-{{ $training['id'] }}-{{ $s['user']['vatsim_id']}}">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">{{__('app/staff/pilot_mine.add_report')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('app.staff.pilot.mine.sessionreport', app()->getLocale()) }}" method="post">
                                @csrf
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="report_box_{{ $training['id'] }}_{{ $s['user']['vatsim_id']}}">{{__('app/staff/pilot_mine.report_textarea')}}</label>
                                    <textarea
                                      class="form-control"
                                      name="report_box"
                                      id="report_box_{{ $training['id'] }}_{{ $s['user']['vatsim_id']}}"
                                      rows="10"
                                      required></textarea>
                                  </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <input type="hidden" name="sessionid" value="{{ $training['id'] }}">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.cancel')}}</button>
                                  <button type="submit" class="btn btn-success">{{__('app/staff/pilot_mine.confirm')}}</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#book-session-{{ $s['user']['vatsim_id'] }}">{{__('app/staff/pilot_mine.btn_booksess')}}</button>
              <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#send-message-{{ $s['user']['vatsim_id'] }}">{{__('app/staff/pilot_mine.btn_sendmsg')}}</button>
              <button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#edit-progress-{{ $s['user']['vatsim_id']}}">{{__('app/staff/pilot_mine.btn_editprog')}}</button>
              <button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#edit_trainingtype_{{ $s['user']['vatsim_id']}}">{{__('app/staff/pilot_mine.btn_editairport')}}</button>
              <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#terminate-{{ $s['user']['vatsim_id']}}">{{__('app/staff/pilot_mine.btn_terminate')}}</button>
              {{-- Book session modal  --}}
              <div class="modal fade" id="book-session-{{ $s['user']['vatsim_id'] }}">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">{{__('app/staff/pilot_mine.bsm_title', ['STUDENT' => $s['user']['fname']])}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('app.staff.pilot.mine.booksession', app()->getLocale()) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="session-date">{{__('app/atc/atc_training_center.date')}}</label>
                              <input type="text" class="form-control" id="session-date-{{ $s['user']['vatsim_id'] }}" name="sessiondate" placeholder="{{__('app/atc/atc_training_center.date')}}">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="starttime">{{__('app/atc/atc_training_center.st_time')}} (UTC)</label>
                              <input type="text" class="form-control" id="starttime-{{ $s['user']['vatsim_id'] }}" name="starttime" placeholder="{{__('app/atc/atc_training_center.st_time')}}">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="endtime">{{__('app/atc/atc_training_center.end_time')}} (UTC)</label>
                              <input type="text" class="form-control" id="endtime-{{ $s['user']['vatsim_id'] }}" name="endtime" placeholder="{{__('app/atc/atc_training_center.end_time')}}">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="reqdetails">{{__('app/staff/pilot_mine.book_details')}}</label>
                          <textarea class="form-control" rows="5" name="reqdetails" id="reqdetails" style="resize: none;" placeholder="..." required></textarea>
                        </div>
                        <div class="form-group">
                          <label for="reqcomment">{{__('app/staff/pilot_mine.comment_for_stu')}}</label>
                          <textarea class="form-control" rows="3" name="reqcomment" id="reqcomment" style="resize: none;" placeholder="..."></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="userid" value="{{ $s['user']['id'] }}">
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.close')}}</button>
                        <button type="submit" class="btn btn-success">{{__('app/staff/pilot_mine.send_req')}}</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              {{-- Edit progress modal  --}}
              <div class="modal fade" id="edit-progress-{{ $s['user']['vatsim_id']}}">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">{{__('app/staff/pilot_mine.epm_title', ['STUDENT' => $s['user']['fname']])}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('app.staff.pilot.mine.progress', app()->getLocale()) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="reqposition">{{__('app/staff/pilot_mine.epm_select', ['STUDENT' => $s['user']['fname']])}}</label>
                          <select class="form-control" name="stuprogress" id="stuprogress">
                            @if ($s['progress'] == 0)
                              <option value="0" disabled selected>{{__('app/staff/pilot_mine.epm_choose')}}...</option>
                            @else
                              <option value="{{ $s['progress'] }}">{{ $steps[$s['progress']]['title'] }}</option>
                            @endif
                            @foreach ($steps as $step)
                              <option value="{{ $loop->index + 1 }}">{{ $step['title'] }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <input type="hidden" name="userid" value="{{ $s['user']['id'] }}">
                        <button type="submit" class="btn btn-danger">{{__('app/staff/pilot_mine.confirm')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.cancel')}}</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              {{-- Send private message  --}}
              <div class="modal fade" id="send-message-{{ $s['user']['vatsim_id'] }}">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">{{__('app/staff/pilot_mine.spmm_title', ['STUDENT' => $s['user']['fname']])}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('app.inmsg.send', app()->getLocale()) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="msgsubject">{{__('app/staff/pilot_mine.spmm_subject')}}</label>
                          <input type="text" class="form-control" id="msgsubject" name="msgsubject" placeholder="{{__('app/staff/pilot_mine.spmm_subject')}}">
                        </div>
                        <div class="form-group">
                          <label for="msgbody">{{__('app/staff/pilot_mine.spmm_msg')}}</label>
                          <textarea class="form-control" rows="15" name="msgbody" id="msgbody" placeholder="{{__('app/staff/pilot_mine.spmm_your_msg')}}"></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="msgrecipient" value="{{ $s['user']['id'] }}">
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.close')}}</button>
                        <button type="submit" class="btn btn-success">{{__('app/staff/pilot_mine.spmm_sendmsg')}}</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              {{-- Edit training airport  --}} 
              <div class="modal fade" id="edit_trainingtype_{{ $s['user']['vatsim_id']}}">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">{{__('app/staff/pilot_mine.eta_title')}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('app.staff.pilot.mine.modapt', app()->getLocale()) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="trainingtype">{{__('app/staff/pilot_mine.eta_label', ['FNAME' => $s['user']['fname']])}}</label>
                          <select class="form-control" name="trainingtype" id="trainingtype">
                            @if (is_null($s['mentoringRequest']['training_type']))
                              <option value="0" disabled selected>{{__('app/staff/pilot_mine.epm_choose')}}...</option>
                            @else
                              <option value="{{ $s['mentoringRequest']['training_type'] }}" disabled selected>{{ $s['mentoringRequest']['training_type'] }}</option>
                            @endif
                            <option value="IFR">IFR</option>
                            <option value="VFR">VFR</option>
                            <option value="IFR & VFR">IFR & VFR</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <input type="hidden" name="studentid" value="{{ $s['user']['id'] }}">
                        <button type="submit" class="btn btn-danger">{{__('app/staff/pilot_mine.confirm')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.cancel')}}</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              {{-- Termination modal  --}}
              <div class="modal fade" id="terminate-{{ $s['user']['vatsim_id']}}">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">{{__('app/staff/pilot_mine.tm_sure')}}</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/pilot_mine.close')}}">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('app.staff.pilot.mine.terminate', app()->getLocale()) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <p>{{__('app/staff/pilot_mine.tm_text', ['STUDENT' => $s['user']['fname']])}}</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <input type="hidden" name="userid" value="{{ $s['user']['id'] }}">
                        <button type="submit" class="btn btn-danger">{{__('app/staff/pilot_mine.confirm')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/pilot_mine.cancel')}}</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>
          </div>
          <script>
            $("#upcoming_sessions_{{ $s['user']['vatsim_id'] }}").DataTable({
              "paging": false,
              "lengthChange": false,
              "searching": false,
              "ordering": false,
              "autoWidth": false,
              "info": false,
              "language": {
                "emptyTable": "{{__('app/staff/pilot_mine.no_training_found')}}"
              }
            });
            $("#solo_sessions_{{ $s['user']['vatsim_id'] }}").DataTable({
              "paging": false,
              "lengthChange": false,
              "searching": false,
              "ordering": false,
              "autoWidth": false,
              "info": false,
              "language": {
                "emptyTable": "{{__('app/staff/pilot_mine.no_solo_found')}}"
              }
            });
            flatpickr("#session-date-{{ $s['user']['vatsim_id'] }}", {
                enableTime: false,
                dateFormat: "d.m.Y",
                minDate: "today",
                allowInput: true,
            });
            flatpickr("#start-date-solo-{{ $s['user']['vatsim_id'] }}", {
                enableTime: false,
                dateFormat: "d.m.Y",
                minDate: "today",
                allowInput: true,
            });
            d = new Date();
            flatpickr("#starttime-{{ $s['user']['vatsim_id'] }}", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultHour: d.getUTCHours(),
                defaultMinute: 00,
                allowInput: true,
                time_24hr: true,
                minuteIncrement: 15
            });
            flatpickr("#endtime-{{ $s['user']['vatsim_id'] }}", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultHour: d.getUTCHours()+1,
                defaultMinute: 00,
                allowInput: true,
                time_24hr: true,
                minuteIncrement: 15
            });
          </script>
        @endforeach
      </div>
    </div>
  </div>
@endsection