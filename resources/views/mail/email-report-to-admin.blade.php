@component('mail::message')
<h4>Dear Admin,</h4>
<strong>{{ $reported_by }}</strong> has reporting about <strong>{{ $about_report }}</strong>.
<hr>
<table cellpadding="0" cellspacing="0" width="100%"
style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
    @if($about_report == 'Transaction')
        <tr>
            <td>Transaction ID = <strong>{{$report->reportable_id}}</strong></td>
        </tr>
        <tr>
            <td>Product:</td>
            <td>{{ $reportable->product->name }} <strong>#{{$reportable->product->id}}</strong></td>
        </tr>
    @elseif($about_report == 'Product')
        <tr>
            <td>Product:</td>
            <td>{{ $reportable->name }} <strong>#{{$report->reportable_id}}</strong></td>
        </tr>
    @endif
    <tr>
        <td>Reason:</td>
        <td>{{ $report->reason }}</td>
    </tr>
    <tr>
        <td>Description:</td>
        <td>{{ $report->description }}</td>
    </tr>
    <tr>
        <td>Date:</td>
        <td>{{ date_format($report->created_at, 'Y-m-d H:i:s')}}</td>
    </tr>
</table>
<p><a href="{{route('console.report.show', $report->id)}}" target="_blank">Click here</a> to review report.</p>
@endcomponent