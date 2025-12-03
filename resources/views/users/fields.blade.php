<ul class="nav nav-tabs" id="navbar" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-pane" type="button" role="tab">
            DATOS DE USUARIO
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="legal-tab" data-bs-toggle="tab" data-bs-target="#legal-pane" type="button" role="tab">
            DATOS LEGALES
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address-pane" type="button" role="tab">
            DATOS DOMICILIARIOS
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="job-tab" data-bs-toggle="tab" data-bs-target="#job-pane" type="button" role="tab">
            DATOS LABORALES
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="bank-tab" data-bs-toggle="tab" data-bs-target="#bank-pane" type="button" role="tab">
            DATOS BANCARIOS
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="appended-tab" data-bs-toggle="tab" data-bs-target="#appended-pane" type="button" role="tab">
            DOCUMENTOS ANEXADOS
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contracts-tab" data-bs-toggle="tab" data-bs-target="#contracts-pane" type="button" role="tab">
            CONTRATOS
        </button>
    </li>
</ul>

<div class="tab-content mb-2">
  <div class="tab-pane fade show active" id="user-pane" role="tabpanel" aria-labelledby="user-tab">
    <div class="row gy-3 mt-2">
        @include('users.custom_fields.user_data_fields')
    </div>
  </div>

  <div class="tab-pane fade" id="legal-pane" role="tabpanel" aria-labelledby="legal-tab">
    <div class="row gy-3 mt-2">
        @include('users.custom_fields.legal_data_fields')
    </div>
  </div>

  <div class="tab-pane fade" id="address-pane" role="tabpanel" aria-labelledby="address-tab">
    <div class="row gy-3 mt-2">
        @include('users.custom_fields.address_data_fields')
    </div>
  </div>
  
  <div class="tab-pane fade" id="job-pane" role="tabpanel" aria-labelledby="job-tab">
    <div class="row gy-3 mt-2">
        @include('users.custom_fields.job_data_fields')
    </div>
  </div>

  <div class="tab-pane fade" id="bank-pane" role="tabpanel" aria-labelledby="bank-tab">
    <div class="row gy-3 mt-2">
        @include('users.custom_fields.bank_data_fields')
    </div>
  </div>

    <div class="tab-pane fade" id="contracts-pane" role="tabpanel" aria-labelledby="contracts-tab">
        <div class="row gy-3 mt-2">
            @include('users.custom_fields.contract_data_fields')
        </div>
    </div>

  <div class="tab-pane fade" id="appended-pane" role="tabpanel" aria-labelledby="appended-tab">
    <div class="row gy-3 mt-2">
        @include('users.custom_fields.appended_data_fields')
    </div>
  </div>

 
  
</div>
