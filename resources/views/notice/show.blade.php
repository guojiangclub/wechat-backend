@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ session('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! session('flash_notification.message') !!}
    </div>
@endif
<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="active"><a href="">{{isset($notice['title'])?$notice['title']:''}}
                <span class="badge"></span></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
                   <div class="panel-body">
                       {{--<div class="hr-line-dashed"></div>--}}
                       <form class="form-horizontal"
                             id="base-form">
                           <div class="form-group">
                               <label class="col-sm-2 control-label">模板ID：</label>
                               <div class="col-sm-9">
                                   <input type="text" class="form-control" placeholder="" value="{{isset($notice['template_id'])?$notice['template_id']:''}}"/>
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="col-sm-2 control-label">标题：</label>
                               <div class="col-sm-9">
                                   <input type="text" class="form-control" placeholder="" value="{{isset($notice['title'])?$notice['title']:''}}"/>
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="col-sm-2 control-label">一级行业：</label>
                               <div class="col-sm-9">
                                   <input type="text" class="form-control" placeholder="" value="{{isset($notice['primary_industry'])?$notice['primary_industry']:''}}"/>
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="col-sm-2 control-label">二级行业：</label>
                               <div class="col-sm-9">
                                   <input type="text" class="form-control" placeholder="" value="{{isset($notice['primary_industry'])?$notice['primary_industry']:''}}"/>
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="col-sm-2 control-label">内容：</label>
                               <div class="col-sm-9">
                                   <textarea style="width: 100%;" rows="12">{{isset($notice['content'])?$notice['content']:''}}</textarea>
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="col-sm-2 control-label">例子：</label>
                               <div class="col-sm-9">
                                   <textarea style="width: 100%;" rows="12">{{isset($notice['example'])?$notice['example']:''}}</textarea>
                               </div>
                           </div>
                       </form>
                     </div>
                </div>
            </div>
        </div>