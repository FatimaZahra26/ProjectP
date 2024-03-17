@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <!-- /Page Header -->
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#">
                                            <img alt="" src="{{ URL::to('/assets/images/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ Session::get('name') }}</h3>
                                                <h6 class="text-muted">{{ Session::get('department') }}</h6>
                                                <small class="text-muted">{{ Session::get('position') }}</small>
                                                <div class="staff-id">User ID : {{ Session::get('user_id') }}</div>
                                                <div class="small doj text-muted">Date of Join : {{ Session::get('join_date') }}</div>
                                                <div class="staff-msg"><a class="btn btn-custom" href="chat.html">Send Message</a></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a href="">{{ Session::get('phone_number') }}</a></div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a href="">{{ Session::get('email') }}</a></div>
                                                </li>
                                                @if(!empty($information))
                                                    <li>
                                                        @if(Auth::user()->user_id == $information->user_id)
                                                        <div class="title">Birthday:</div>
                                                        <div class="text">{{date('d F, Y',strtotime($information->birth_date)) }}</div>
                                                        @else
                                                        <div class="title">Birthday:</div>
                                                        <div class="text">N/A</div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        @if(Auth::user()->user_id == $information->user_id)
                                                        <div class="title">Address:</div>
                                                        <div class="text">{{ $information->address }}</div>
                                                        @else
                                                        <div class="title">Address:</div>
                                                        <div class="text">N/A</div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        @if(Auth::user()->user_id == $information->user_id)
                                                        <div class="title">Gender:</div>
                                                        <div class="text">{{ $information->gender }}</div>
                                                        @else
                                                        <div class="title">Gender:</div>
                                                        <div class="text">N/A</div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <div class="title">Reports to:</div>
                                                        <div class="text">
                                                            <div class="avatar-box">
                                                                <div class="avatar avatar-xs">
                                                                    <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                {{ Auth::user()->name }}
                                                            </a>
                                                        </div>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <div class="title">Birthday:</div>
                                                        <div class="text">N/A</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Address:</div>
                                                        <div class="text">N/A</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Gender:</div>
                                                        <div class="text">N/A</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Reports to:</div>
                                                        <div class="text">
                                                            <div class="avatar-box">
                                                                <div class="avatar avatar-xs">
                                                                    <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                {{ Auth::user()->name }}
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endif    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
					
            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a></li>
                            <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Bank & Statutory <small class="text-danger">(Admin Only)</small></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="tab-content">
                <!-- Profile Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Personal Informations <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                    @if (!empty($userInformation))
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Passport No.</div>
                                                <div class="text">{{ $userInformation->passport_no }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Passport Exp Date.</div>
                                                <div class="text">{{ $userInformation->passport_expiry_date }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Tel</div>
                                                <div class="text"><a href="">{{ $userInformation->tel }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Nationality</div>
                                                <div class="text">{{ $userInformation->nationality }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Religion</div>
                                                <div class="text">{{ $userInformation->religion }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Marital status</div>
                                                <div class="text">{{ $userInformation->marital_status }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Employment of spouse</div>
                                                <div class="text">{{ $userInformation->employment_of_spouse }}</div>
                                            </li>
                                            <li>
                                                <div class="title">No. of children</div>
                                                <div class="text">{{ $userInformation->children }}</div>
                                            </li>
                                        </ul>
                                    @else
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Passport No.</div>
                                            <div class="text">N/A</div>
                                        </li>
                                        <li>
                                            <div class="title">Passport Exp Date.</div>
                                            <div class="text">N/A</div>
                                        </li>
                                        <li>
                                            <div class="title">Tel</div>
                                            <div class="text"><a href="">N/A</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Nationality</div>
                                            <div class="text">N/A</div>
                                        </li>
                                        <li>
                                            <div class="title">Religion</div>
                                            <div class="text">N/A</div>
                                        </li>
                                        <li>
                                            <div class="title">Marital status</div>
                                            <div class="text">N/A</div>
                                        </li>
                                        <li>
                                            <div class="title">Employment of spouse</div>
                                            <div class="text">N/A</div>
                                        </li>
                                        <li>
                                            <div class="title">No. of children</div>
                                            <div class="text">N/A</div>
                                        </li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Emergency Contact <a href="#" class="edit-icon" data-toggle="modal" data-target="#emergency_contact_modal"><i class="fa fa-pencil"></i></a></h3>
                                    <h5 class="section-title">Primary</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Name</div>
                                            <div class="text">John Doe</div>
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            <div class="text">Father</div>
                                        </li>
                                        <li>
                                            <div class="title">Phone </div>
                                            <div class="text">9876543210, 9876543210</div>
                                        </li>
                                    </ul>
                                    <hr>
                                    <h5 class="section-title">Secondary</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Name</div>
                                            <div class="text">Karen Wills</div>
                                        </li>
                                        <li>
                                            <div class="title">Relationship</div>
                                            <div class="text">Brother</div>
                                        </li>
                                        <li>
                                            <div class="title">Phone </div>
                                            <div class="text">9876543210, 9876543210</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                </div>
            </div>
        </div>
        <!-- /Experience Modal -->

        <!-- /Page Content -->
    </div>
@endsection