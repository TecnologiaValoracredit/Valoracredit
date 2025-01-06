<div class="d-flex justify-content-center">
    <div id="toggleAccordionFilters" class="accordion mb-3 w-75">
        <div class="card">
            <div class="card-header" id="filtersHeader">
                <section class="mb-0 mt-0">
                    <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#filtersAccordion" aria-expanded="false" aria-controls="filtersAccordion">
                        Filtros  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                    </div>
                </section>
            </div>
        
            <div id="filtersAccordion" class="collapse" aria-labelledby="filtersHeader" data-bs-parent="#toggleAccordionFilters">
                <div class="card-body">
                    <form id="filters-form">
                        @foreach($rows as $row)
                            <div class="row">
                                @foreach($row as $input)
                                    <div class="mb-2 {{$input['class']}}">
                                        @if($input["type"] == "select")
                                            @include("components.custom.forms.input-select", [
                                                "id" => $input["id"],
                                                "name" => $input["name"],
                                                "label" => $input["label"],
                                                "class" => "datatable-filter",
                                                "value" => $input["value"],
                                                "elements" => $input["elements"]
                                            ])
                                        @else
                                            @include("components.custom.forms.input", [
                                                "id" => $input["id"],
                                                "name" => $input["name"],
                                                "type" => $input["type"] ?? "text",
                                                "placeholder" => $input["placeholder"] ?? $input["label"],
                                                "label" => $input["label"],
                                                "class" => "datatable-filter",
                                                "value" => $input["value"]
                                            ])
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </form>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger mt-3 me-2" onclick="clearFilters()">Limpiar filtros</button>
                        <button class="btn btn-dark mt-3" onclick="filterDT()">Filtrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>