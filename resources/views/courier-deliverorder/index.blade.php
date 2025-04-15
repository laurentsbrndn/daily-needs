@extends ('courier-sidebar.index')

@section('container')

    <div class="content">
        <h2>Courier Deliveries</h2>

        <ul class="nav nav-tabs" id="deliveryTabs">
            <li class="nav-item">
                <a class="nav-link active" id="toShipTab" data-bs-toggle="tab" href="#toShip">🔄 To Ship</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="inTransitTab" data-bs-toggle="tab" href="#inTransit">🚚 In Transit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="deliveredTab" data-bs-toggle="tab" href="#delivered">📦 Delivered</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Tab 1: To Ship -->
            <div class="tab-pane fade show active" id="toShip">
                <h3>Orders Ready to Ship</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($toShip as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td><button class="btn btn-primary">Confirm</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab 2: In Transit -->
            <div class="tab-pane fade" id="inTransit">
                <h3>Orders in Transit</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Shipment ID</th>
                            <th>Customer</th>
                            <th>Shipment Start</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inProgress as $shipment)
                        <tr>
                            <td>{{ $shipment->id }}</td>
                            <td>{{ $shipment->transaction->customer_name }}</td>
                            <td>{{ $shipment->shipment_date_start }}</td>
                            <td>
                                @if (!$shipment->shipment_date_end)
                                <form action="{{ route('courier.confirmDelivery', $shipment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Confirm Delivery</button>
                                </form>
                                @else
                                <span>Already Delivered</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tab 3: Delivered -->
            <div class="tab-pane fade" id="delivered">
                <h3>Delivered Orders</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Shipment ID</th>
                            <th>Customer</th>
                            <th>Delivered On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($delivered as $shipment)
                        <tr>
                            <td>{{ $shipment->id }}</td>
                            <td>{{ $shipment->transaction->customer_name }}</td>
                            <td>{{ $shipment->shipment_date_end }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection