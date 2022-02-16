@extends('frontEnd.masterPage')
@section('title')
    About us ||
@stop
@section('style')
    <style>
        .table > thead > tr > th{border: none;}
        .table .table-borderless tr td{border: none;}
    </style>
@stop
@section('mainPart')
<div class="grid_3">
    <div class="container">
        <div class="breadcrumb1">
            <ul>
                <a href="{{ url('/') }}"><i class="fa fa-home home_1"></i></a>
                <span class="divider">&nbsp;|&nbsp;</span>
                <li class="current-page">About US</li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>
                    Marriagematchbd.com is a "marriage mediator" service provider organization.
                    We are working for those, who are actually searching for a suitable life partner for their life. 
                    If you are a Muslim residing in Bangladesh or abroad and serious about searching a Life Partner for getting married, 
                    then you reached the right place to find your life partner. <a href="{{ url('/') }}">Marriagematchbd.com</a> 
                    for weddings provides offline and online both services. Whether you are from any city of Bangladesh and live anywhere,
                    <a href="{{ url('/') }}">Marriagematchbd.com</a>  is the right place, here you can search a suitable,
                    exact life partner for you / your son or Daughter. We fully protect your privacy and personal information 
                    and offer cordial services, friendly environment, a suitable match, a good marriage proposal, organized 
                    meetings arranged for you, until you find a suitable life partner, we sincerely try to do our best for you. 
                    <a href="{{ url('/') }}">Marriagematchbd.com</a>  is not just a name. It's a multi-year experience and a successful elite agency.
                    Since its development, <a href="{{ url('/') }}">Marriagematchbd.com</a>  has been successful in arranging matchmaking for thousands of couples.
                    Our reputation for providing professional Marriage services in Bangladesh is unsurpassed. We are a unique, 
                    experts and creative matchmakers’ team, those educated, smart & energetic. Not in the traditional trend, 
                    we are in the advanced touches. We believe that marriage for each person can be unique and very dynamic - if you can choose the ideal life partner.
                     We can give you the educated, respected, elite, well-established family that fits for you / your son or daughter. 
                     Here You can get many Profiles/Bio-data of brides /grooms, from which you can find your best, ideal, exact life partner.
                      If you want to get our offline services, please come to our office directly and want to know more details then you can call us. 
                      <a href="{{ url('/') }}">Marriagematchbd.com</a>  is always ready to provide services, you can get complete cooperation. We believe   
                      that the most important factor in marriage service-orientated business in trust. 
                      If you ever have a problem with our services please inform us. We are totally committed to the best service, 
                      it is our number one priority. <a href="{{ url('/') }}">Marriagematchbd.com</a>  is a specialist elite matrimonial agency 
                      whose target is not only to help people to meet each other but to get married.
                </p>                
            </div>
        </div>
    </div>
</div>
@endsection