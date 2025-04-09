@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush


@section('content')

        <div class="admin-container">
            <aside class="sidebar">
                <div class="brand-container">
                    <h1 class="brand-title">lumé</h1>
                    <span class="admin-label">Admin Panel</span>
                </div>
                
                <!-- LOGOUT ROUTE NEEDS TO BE FIGURED OUT! -->
                <ul class="nav-menu">
                    <li><a href="{{ route('welcome') }}">Back to Site</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </aside>
            

            <main class="main-content">
                <div class="page-header">
                    <h2 class="page-title">User Management</h2>
                </div>
                

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Approval</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->Role) }}</td>

                                        <td>
                                            <span class="status-badge {{ $user->IsApproved ? 'status-approved' : 'status-pending' }}">
                                                {{ $user->IsApproved ? 'Approved' : 'Pending' }}
                                            </span>
                                        </td>

                                        <td>
                                            <form action="{{ url('/admin/users/' . $user->id . '/toggle-approval') }}" method="POST" class="approval-form">
                                                @csrf
                                                @method('PATCH')
                                                <label class="approval-toggle">
                                                    <input type="checkbox" {{ $user->IsApproved ? 'checked' : '' }} 
                                                        onchange="this.form.submit()">
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>


@endsection