@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.event.title') }}
    </div>   
    <div class="card-body">
        <div class="form-group">
            {{-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.events.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> --}}
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.status') }}
                        </th>
                        <td>
                            {{ $event->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.id') }}
                        </th>
                        <td>
                            {{ $event->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.room') }}
                        </th>
                        <td>
                            {{ $event->room->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.user') }}
                        </th>
                        <td>
                            {{ $event->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.title') }}
                        </th>
                        <td>
                            {{ $event->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.start_time') }}
                        </th>
                        <td>
                            {{ $event->start_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.end_time') }}
                        </th>
                        <td>
                            {{ $event->end_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.description') }}
                        </th>
                        <td>
                            {{ $event->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.resp') }}
                        </th>
                        <td>
                            {{ $event->room->resp }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.resp_no') }}
                        </th>
                        <td>
                            {{ $event->room->resp_no }}
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.events.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            {{-- <div style="margin-bottom: 10px;" class="d-block text-right">
                <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('showpdf', $event->id) }}">
                    {{ trans('global.view_file') }}
                </a>
                </div> --}}
            </div>
        </div>
    </div>
        
</div>



@endsection