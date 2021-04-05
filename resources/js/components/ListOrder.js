import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import parameters from '../parameters'

export default class ListOrder extends Component {

    constructor(props) {
        super(props)

        this.state = {
            orders: [],
        }

    }

    async componentDidMount() {
        try {
            let config = {
                method: 'POST',
                headers: parameters.headers,
                body: JSON.stringify({ 'orderId': this.state.orderId })
            }

            let res = await fetch(parameters.url + 'order/listOrder', config)
            let data = await res.json();

            this.setState({
                orders: data
            })

        } catch (error) {
            this.setState({
                error
            })
        }
    }


    render() {
        return (
            <div>
                <a href="/" target="_selt">
                    <button className='btn btn-lg btn-block btn-outline-warning' type="button">Inicio</button>
                </a>
                <h4>Lista de ordenes realizadas</h4>
                <table className="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.state.orders.map((order) => (
                            <tr key={order.id} >
                                <td>{order.name}</td>
                                <td>{order.product_name}</td>
                                <td>{order.price}</td>
                                <td>{order.status}</td>
                                <td>
                                    <a href={"/informationOrder/" + order.id} target="_selt" >ver</a>
                                </td>
                            </tr>
                        ))}

                    </tbody>
                </table>
            </div>
        );
    }
}
if (document.getElementById('content_listOrder')) {
    ReactDOM.render(<ListOrder />, document.getElementById('content_listOrder'));
}
