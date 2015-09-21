{{ $data->name }}, 

Your booking has been made and payment is confirmed. 

Staying at {{ $data->accom }} 
Arriving on {{ $data->arrive }}
Leaving on {{ $data->depart }}

We hope you enjoy your stay and have a lovely holiday. 

In the meantime, should you need to contact us simply reply to this email. 

Best regards,


The {{ Config::get('cottaging.site-name') }} Team
--