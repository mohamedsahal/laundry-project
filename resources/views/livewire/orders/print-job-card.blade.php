<div class="tw-w-full tw-h-full" x-data="mainPage">
    <style>
         @page {
            background-color: red
            size: 2in auto;
            margin: 0mm 0 0mm 0;
        }
        body {
            width : 2in;
            overflow: hidden;
            margin: 0px;
            font-family: Calibri;
        }
        @media screen {
            .header,
            .footer {
                display: none;
            }
        }
    </style>
    @foreach ($items as $item)
    <div class="tw-w-full tw-flex tw-flex-col tw-items-center tw-overflow-clip tw-break-before-page "  x-data="me">
        <div class="tw-font-bold">{{ $sitename }}</div>
        <div class="tw-font-medium">Print Job</div>

        <div class="tw-w-full tw-justify-between tw-flex tw-items-center tw-mt-1">
            <div class="tw-w-[6rem] tw-shrink-0">Order #</div>
            <div class="tw-text-end tw-w-full">#{{ $order->order_number }}</div>
        </div>
        <div class="tw-w-full tw-justify-between tw-flex tw-mt-1">
            <div class="tw-w-[6rem] tw-shrink-0">Customer</div>
            <div class="tw-text-end tw-w-full  tw-shrink tw-break-all">{{ $customer->name ?? 'Walk-In ' }}</div>
        </div>
        @if ($customer)
            
        <div class="tw-w-full tw-justify-between tw-flex tw-items-center tw-mt-1">
            <div class="tw-w-[6rem] tw-shrink-0">Phone</div>
            <div class="tw-text-end tw-w-full">{{  $customer && $customer->phone ?  (int)$customer->phone : 'Phone' }}</div>
        </div>
        @endif
        <div class="tw-w-full tw-justify-between tw-flex tw-mt-1 tw-border-y tw-py-1 tw-border-dashed">
            <div class="tw-flex tw-flex-col tw-w-full">
                @php
                $service = \App\Models\Service::where('id', $item->service_id)->first();
                @endphp
                <div class="tw-w-full tw-font-bold">{{ $service->service_name }}</div>
                <div class="tw-w-full tw-justify-between tw-flex tw-items-center ">
                    <div class="tw-w-full ">[{{ $item->service_name }}]</div>
                </div>
            </div>
            <div class=" tw-font-bold tw-shrink-0 tw-text-start">{{ $item->service_quantity }}x</div>

        </div>
        <div class="tw-w-full">
            <svg class="tw-w-full " x-ref="svg"></svg>
        </div>
        
        <div class=" tw-hidden" x-ref="id">{{$order->order_number}}</div>
       
    </div>
    @endforeach

    
    <script>
        const me = () => {
            return{
                init(){
                    JsBarcode(this.$refs.svg, this.$refs.id.innerHTML,{
                        fontSize: 15,
                        height : 40
                    });
                }
            }
        }
    </script>
     <script>
        const mainPage = () => {
            return{
                init(){
                    setTimeout(() => {
                        window.print();
                        window.addEventListener('focus',() => {
                            window.close()
                        })
                    }, 200);
                }
            }
        }
    </script>
   
</div>