@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Analytics Dashboard</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-info p-3">
                    <div class="inner">
                        <h3>1.7M</h3>
                        <p>Cash Deposits</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-cash"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-success p-3">
                    <div class="inner">
                        <h3>9M</h3>
                        <p>Invested Dividends</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-warning p-3">
                    <div class="inner">
                        <h3>$563</h3>
                        <p>Capital Gains</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary"><i class="bi bi-file-earmark-text"></i> View Report</button>
    </div>
@endsection
