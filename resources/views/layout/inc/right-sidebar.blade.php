<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body">
            <ul id="themecolors" class="m-t-20">
                <li><b>With Light sidebar</b></li>
                <li><a href="" data-theme="default" class="default-theme">1</a></li>
                <li><a href="javascript:void(0)" data-theme="green" title="Green" class="green-theme {{session()->get('settings')[0]['theme'] == 'green' ? 'working':''}}">2</a></li>
                <li><a href="javascript:void(0)" data-theme="red" class="red-theme {{session()->get('settings')[0]['theme'] == 'red' ? 'working':''}}">3</a></li>
                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme {{session()->get('settings')[0]['theme'] == 'blue' ? 'working':''}}">4</a></li>
                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme {{session()->get('settings')[0]['theme'] == 'purple' ? 'working':''}}">5</a></li>
                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme {{session()->get('settings')[0]['theme'] == 'megna' ? 'working':''}}">6</a></li>
                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme {{session()->get('settings')[0]['theme'] == 'default-dark' ? 'working':''}}">7</a></li>
                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme {{session()->get('settings')[0]['theme'] == 'green-dark' ? 'working':''}}">8</a></li>
                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme {{session()->get('settings')[0]['theme'] == 'red-dark' ? 'working':''}}">9</a></li>
                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme {{session()->get('settings')[0]['theme'] == 'blue-dark' ? 'working':''}}">10</a></li>
                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme {{session()->get('settings')[0]['theme'] == 'purple-dark' ? 'working':''}}">11</a></li>
                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme {{session()->get('settings')[0]['theme'] == 'megna-dark' ? 'working':''}}">12</a></li>
            </ul>
            {{-- <ul class="m-t-20 chatonline">
                <li><b>Chat option</b></li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="{{ asset('material') }}/assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                </li>
            </ul> --}}
        </div>
    </div>
</div>
@push('js')
    @include('elements.color-switcher-js')
@endpush
