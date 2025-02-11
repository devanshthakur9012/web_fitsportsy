@extends('frontend.master', ['activePage' => null])
@section('title', __('Frequently Asked Questions'))
@section('content')
    <section class="FAQ mt-5">
        <div class="container">
            <h2 class="text-center">Playoffz FAQ: Discover, Book, Enjoy Coachings</h2>
            <div class="row mt-3">
                <div class="col-sm-12">
                    @foreach ($faq as $item)
                        <div class="card shadow-none">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <h5 class="mb-0"> Q{{$loop->index+1}}.  {{ $item['question'] }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row card-body">
                                <div class="col-md-12 ">
                                    <p class="mb-0">{{ $item['answer'] }}</p>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [{
        "@type": "Question",
        "name": "What is Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Playoffz is a premier platform where users can discover and book packages for live sports coachings such as badminton, cricket, football, and more happening across cities like Delhi, Bengaluru, Mumbai, Hyderabad, and Chennai."
        }
      },{
        "@type": "Question",
        "name": "Which cities host coachings listed on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Playoffz covers a wide range of coachings in cities like Delhi, Bengaluru, Mumbai, Chennai, Hyderabad, Kochi, and Pune, along with many other locations across India."
        }
      },{
        "@type": "Question",
        "name": "How do I find badminton coachings on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Go to the Badminton coaching category page on Playoffz.in to explore upcoming badminton coachings in cities like Chennai, Kochi, Bengaluru, and Hyderabad."
        }
      },{
        "@type": "Question",
        "name": "Can I book packages for football coachings on Playoffz?",
        "acceptedAnswer": {	
          "@type": "Answer",
          "text": "Absolutely! Visit the Football coaching page on Playoffz.in to view and book packages for football matches in Kolkata, Mumbai, Goa, Bengaluru, and more."
        }
      },{
        "@type": "Question",
        "name": "What types of coachings are listed on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Playoffz lists a variety of sports coachings, including badminton, cricket, skating, chess, swimming, tennis, volleyball, running, and pickleball, in multiple cities across India."
        }
      },{
        "@type": "Question",
        "name": "Does Playoffz cover international sports coachings?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Currently, Playoffz focuses on sports coachings organized across major cities in India, such as Delhi, Bengaluru, Chennai, and Mumbai, but it may expand to international events in the future."
        }
      },{
        "@type": "Question",
        "name": "Can I find local sports coachings in small cities on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Yes, in addition to major cities like Hyderabad and Chennai, Playoffz features coachings held in smaller cities like Coimbatore, Thanjavur, and Pondicherry."
        }
      },{
        "@type": "Question",
        "name": "Is it safe to book packages on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Yes, Playoffz ensures a secure and seamless booking process, allowing users to book packages confidently for their favorite live coachings."
        }
      },{
        "@type": "Question",
        "name": "Can I filter coachings by sport or location on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Absolutely! Use the filtering options on Playoffz.in to find coachings by specific sports, such as skating or tennis, or locations like Hyderabad and Mumbai."
        }
      },{
        "@type": "Question",
        "name": "What should I do if a coaching is canceled?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "If a coaching is canceled, Playoffz will notify ticket holders promptly, and refunds will be processed based on the event\u2019s cancellation policy."
        }
      },{
        "@type": "Question",
        "name": "Does Playoffz offer discounts on ticket bookings?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Playoffz occasionally provides discounts and promotional offers. Keep an eye on the website for special deals on live sports coaching tickets."
        }
      },{
        "@type": "Question",
        "name": "How can I stay updated about upcoming coachings on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Subscribe to the Playoffz newsletter to get notified about new coachings, events, and exclusive offers across cities like Mumbai, Delhi, and Chennai."
        }
      },{
        "@type": "Question",
        "name": "Can I suggest a sports coaching to be listed on Playoffz?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Yes, Playoffz welcomes suggestions! Contact the support team to share information about sports coachings you would like to see listed on the platform."
        }
      }]
    }
    </script>    
@endpush