@extends('layouts.app')

@section('page-title')
  News Manager | {{ Auth::user()->fname }}
@endsection

@section('page-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('app/staff/news.page_header')}}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@endsection

@section('page-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="{{ asset('dashboard/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/jquery/jquery.validate.js') }}"></script>
<script src="{{ asset('dashboard/jquery/additional-methods.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2">
      <div class="info-box elevation-3">
        <span class="info-box-icon bg-info"><i class="fas fa-newspaper"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{{__('app/staff/news.pill_one')}}</span>
          <span class="info-box-number">0</span>
        </div>
      </div>
      <button class="btn btn-flat btn-success btn-block" data-target="#new_post" data-toggle="modal">{{__('app/staff/news.btn_newpost')}}</button>
      <div class="modal fade" id="new_post">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('app/staff/news.cr_title')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.news.add', app()->getLocale()) }}" method="post">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="title">{{__('app/staff/news.cr_tit')}}</label>
                  <input class="form-control" type="text" name="title" id="title" placeholder="{{__('app/staff/news.cr_tit_plac')}}" required />
                </div>
                <div class="form-group">
                  <label for="content">{{__('app/staff/news.cr_content')}}</label>
                  <textarea class="form-control" name="content" id="content" rows="10" required placeholder="{{__('app/staff/news.cr_content_plac')}}"></textarea>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/news.cancel')}}</button>
                <button type="submit" class="btn btn-success">{{__('app/staff/news.create')}}</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </div>
    <div class="col-md-5">
      <div class="card card-dark elevation-3">
        <div class="card-header">
          <h3 class="card-title">{{__('app/staff/news.l_title')}}</h3>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <th>{{__('app/staff/news.cr_tit')}}</th>
              <th>{{__('app/staff/news.l_status')}}</th>
              <th></th>
            </thead>
            <tbody>
              @if (count($newslist) > 0)
              @foreach ($newslist as $n)
              <tr>
                <td>{{$n['title']}}</td>
                <td>
                  @if ($n['published'] == true)
                  {{__('app/staff/news.l_published')}}
                  @else
                  {{__('app/staff/news.l_draft')}}
                  @endif
                </td>
                <td align="right"><button class="btn btn-info btn-flat" id="post_{{$n['id']}}">{{__('app/staff/news.l_btn')}}</button></td>
              </tr>
              <script>
                $("#post_{{$n['id']}}").click(function() {
                  $("#selpost_title").text("{{$n['title']}}");
                  $("#selpost_description").html(`{{$n["content"]}}`);
                  $("#selpost_author").attr('value', '{{$n["author"]["fname"]}} {{$n["author"]["lname"]}}');
                  $("#selpost_date").attr('value', '{{ Illuminate\Support\Carbon::createFromFormat("Y-m-d H:i:s", $n["created_at"])->format("Y.m.d | H:i\z") }}');
                  $("#selpost_editbtn").html('<button class="btn btn-info btn-flat float-right ml-2" type="button" data-toggle="modal" data-target="#edit_post">{{__("app/staff/news.l_editbtn")}}</button>');
                  $("#selpost_delbtn").html('<button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#delete_event">{{__("app/staff/news.l_del")}}</button>');
                  $("#selpost_postid").attr('value', '{{$n["id"]}}');
                  $("#edittitle").attr('value', '{{$n["title"]}}');
                  $("#editcontent").text(`{!!$n["content"]!!}`);
                  $("#editpostid").attr('value', '{{$n["id"]}}');
                  $("#selpost_delbtn").show();
                })
              </script>
              @endforeach
              @else
              <tr>
                <td>{{__('app/staff/news.l_nopost')}}</td>
                <td>-</td>
                <td align="right"><button class="btn btn-flat btn-success" data-target="#new_post" data-toggle="modal">{{__('app/staff/news.btn_newpost')}}</button></td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card card-info elevation-3">
        <div class="card-header">
          <h3 class="card-title" id="selpost_title">({{__('app/staff/news.no_post')}})</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="selpost_description_label">{{__('app/staff/news.cr_content')}}</label>
            <textarea name="selpost_description" id="selpost_description" rows="15" class="form-control" readonly>({{__('app/staff/news.no_post')}})</textarea>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="selpost_author">{{__('app/staff/news.author')}}</label>
                <input class="form-control" type="text" id="selpost_author" name="selpost_author" disabled />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="selpost_date">{{__('app/staff/news.date')}}</label>
                <input class="form-control" type="text" id="selpost_date" name="selpost_date" disabled />
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div id="selpost_editbtn"></div>
          <div id="selpost_delbtn"></div>
        </div>
      </div>
      <div class="modal fade" id="edit_post">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('app/staff/news.ed_title')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.news.edit', app()->getLocale()) }}" method="post">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="edittitle">{{__('app/staff/news.cr_tit')}}</label>
                  <input class="form-control" type="text" name="edittitle" id="edittitle" placeholder="{{__('app/staff/news.cr_tit_plac')}}" required />
                </div>
                <div class="form-group">
                  <label for="editcontent">{{__('app/staff/news.cr_content')}}</label>
                  <textarea class="form-control" name="editcontent" id="editcontent" rows="15" required placeholder="{{__('app/staff/news.cr_content_plac')}}"></textarea>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <input type="hidden" name="postid" id="editpostid" value="">
                <button type="submit" class="btn btn-danger">{{__('app/staff/news.confirm')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/news.cancel')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="delete_event">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('app/staff/news.are_u_sure')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="{{__('app/staff/atc_mine.close')}}">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('app.staff.news.delete', app()->getLocale()) }}" method="post">
              @csrf
              <div class="modal-body">
                {{__('app/staff/news.are_u_sure_2')}}
              </div>
              <div class="modal-footer justify-content-between">
                <input type="hidden" name="postid" id="selpost_postid" value="">
                <button type="submit" class="btn btn-danger">{{__('app/staff/news.confirm')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app/staff/news.cancel')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('#selpost_delbtn').hide();
</script>
@endsection