@extends('layouts/main')
@section('content_body')


<div class="filler"></div>
<div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent mp-overflow-y dashboard ">
  <div class="row no-gutter mp-pt1 main-dashboard grid gap-10">
    <div class="col">
      <div class="row no-gutter gap-10">
        <div class="col-12">
          <div class="card grid flex-row user-details" style="min-height: 146px;  ">
            <div class="details d-flex flex-column" style="height: 100%">
              <label for="">
                Settings
              </label>
              <div style="margin-top: auto" class="mp-mb1">
              </div>
            </div>
            <div class="image-profile items-center" style="width: 100%; height: 100%; ">
             
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card grid campus-content" style="min-height: 134px;">
            <div class="col-campus">
              <div id="campusSelector" class="mp-dropdown mp-ph3">
              
              </div>
            </div>
            <div class="col-campus">
              <div class=" mp-pv3">
                
              </div>
            </div>
            <div class="col-campus">
              <div class=" mp-pv3">
                
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="right-dashboard col grid side-dashboard gap-10">
      <div class="card">
        <div class="content-right">
        </div>
      </div>
      <div class="card">
        <div class="content-right">
         </div>
      </div>
      <div class="card">
        <div class="content-right">
          </div>
      </div>
      <div class="card">
        <div class="content-right">
         </div>
      </div>
    </div>

  </div>

</div>

@endsection