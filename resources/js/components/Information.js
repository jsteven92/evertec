import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import parameters from '../parameters'

export default class Information extends Component {

    constructor(props) {
        super(props)

        let orderId = document.getElementById('orderId').value
        this.state = {
            orderId: orderId,
            statusOrder: 'CREATED',
            name: '',
            email: '',
            mobile: '',
            product_name: '',
            product_price: '',
            process_url: '',
            status_payment: '',
            date_last_updated: '',
        }

    }

    async componentDidMount() {
        try {
            let config = {
                method: 'POST',
                headers: parameters.headers,
                body: JSON.stringify({ 'orderId': this.state.orderId })
            }

            let res = await fetch(parameters.url + 'order/informationOrder', config)
            let data = await res.json();

            this.setState({
                statusOrder: data.order.status,
                name: data.order.name,
                email: data.order.email,
                mobile: data.order.mobile,
                product_name: data.order.product_name,
                product_price: data.order.price,
                process_url: data.payment[0].process_url,
                status_payment: data.payment[0].status,
                date_last_updated: data.payment[0].called_api_at,
            })

        } catch (error) {
            this.setState({
                error
            })
        }
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">

                    <div className="col-md-12">
                        <div className="card mb-4 box-shadow">
                            <div className="card-header">
                                <h4 className="my-0 font-weight-normal">Estado {this.state.statusOrder}</h4>
                            </div>
                            <div className="card-body">
                                <h1 className="card-title pricing-card-title"><small className="text-muted">Resumen de la order {this.state.orderId}</small></h1>
                                <ul className="list-unstyled mt-3 mb-4">
                                    <li>Nombre: {this.state.name}</li>
                                    <li>Email: {this.state.email}</li>
                                    <li>Numero celular: {this.state.mobile}</li>
                                    <li>Producto: {this.state.product_name}</li>
                                    <li>Precio: {this.state.product_price}</li>
                                    <li>Url de pago: {this.state.process_url}</li>
                                    <li>Estado del pago: {this.state.status_payment}</li>
                                    <li>Última actualización del estado del pago: {this.state.date_last_updated}</li>
                                </ul>
                                <a href={this.state.process_url} target="_selt">
                                    <button className={this.state.status_payment == 'PENDING' ? 'btn btn-lg btn-block btn-outline-primary': 'btn btn-lg btn-block btn-outline-primary hide'} type="button" >Realizar Pago</button>
                                </a>
                                <a href="/" target="_selt">
                                    <button className='btn btn-lg btn-block btn-outline-success' type="button" >Seguir comprando</button>
                                </a>
                            </div>
                        </div>



                    </div>
                </div>

            </div>
        );
    }
}
if (document.getElementById('content_information')) {
    ReactDOM.render(<Information />, document.getElementById('content_information'));
}
