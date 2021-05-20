<x-app-layout>
    @section('title')
        FAQ
    @endsection
    <div class="col-12 faq main-content">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">Frequently Asked Questions</h2>
                <div class="accordion" id="accordion">
                    @foreach ($faq as $item)
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="heading{{$item->id}}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#data{{$item->id}}" aria-expanded="true" aria-controls="collapseOne">
                                {{ $item->title }}
                            </button>
                        </h4>
                        <div id="data{{$item->id}}" class="accordion-collapse collapse multi-collapse show" aria-labelledby="heading{{$item->id}}"
                            data-bs-parent="#accordion">
                            <div class="accordion-body">
                               {!!nl2br($item->question) !!}
                            </div>
                        </div>
                        {{-- <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Question 2
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse multi-collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Question 3
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse multi-collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur.
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    
                    @endforeach
                </div>
            </div>
        </div>
</x-app-layout>
