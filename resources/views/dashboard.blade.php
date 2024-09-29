<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('url.shortener.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 m-auto">
                                <label for="basic-url">Enter Your URL</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="original_url">
                                </div>
                                <button type="submit" class="btn btn-danger mt-2">Generate Shortener URL</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-md-8 m-auto">
                            <div class="gig-message-start-wrap">
                                <div class="all-message-wrap msg-row-reverse">
                                @forelse($UrlShorteners as $url)
                                    <div class="single-message-item">
                                        <div class="top-part">
                                            <div class="thumb">
                                                <span class="title">
                                                    {{ substr($url->user->name ?? __('Unknown'),0,1)}}
                                                </span>
                                            </div>
                                            <div class="content">
                                                <h6 class="title fw-10">
                                                    {{$url->user->name ?? __('Unknown')}}
                                                </h6>

                                                <div class="link-card-body mt-4">
                                                    <a href="{{ route('shortener.url.link',$url->shortener_url) }}" class="shortener-url" target="_blank" data-id="{{ $url->id }}" id="count_link">
                                                        {{ route('shortener.url.link', $url->shortener_url) }}
                                                    </a>
                                                    <a href="#" class="orginal-url">{{ $url->original_url }}</a>

                                                    <div class="link-card-footer">
                                                        <span class="engagements">Click Count : {{ $url->click }}</span>
                                                        <span class="time"> Date: {{date_format($url->created_at,'d M Y')}}</span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="alert alert-warning">{{__('no shortener url found')}}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#count_link').on('click', function(event) {
            event.preventDefault();
            var href = $(this).attr('href');
            var id = $(this).data('id');
            
            $.ajax({
                url: "{{ route('shortener.url.link.count') }}",
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.open(href, '_blank');
                }
            });
        });
    });
</script>

</x-app-layout>