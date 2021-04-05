import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import TransferForm from './sections/index/TransferForm'
import ListProducts from './sections/index/ListProducts'
import DetailProduc from './sections/index/DetailProduc'

import parameters from '../parameters'

export default class Index extends Component {

    constructor(props) {
        super(props)

        this.state = {
            product: [],
            listProducts: [],
            productId: 1,
            transfer: [],
            error: null,
            form: {
                customer_name: 'Carlos andres',
                customer_email: 'test@test.com',
                customer_mobile: '123456'
            }
        }

        this.handleChange = this.handleChange.bind(this)
        this.handleSubmit = this.handleSubmit.bind(this)
        this.handleClick = this.handleClick.bind(this)
    }

    async handleSubmit(e) {
        e.preventDefault();

        try {

            let form_data = {
                "customer_name": this.state.form.customer_name,
                "customer_email": this.state.form.customer_email,
                "customer_mobile": this.state.form.customer_mobile,
                "product_id": this.state.product.id,
                "price": this.state.product.price,
                "payment": {
                    "currency": "COP",
                    "total": this.state.product.price
                }

            }
            let config = {
                method: 'POST',
                headers: parameters.headers,
                body: JSON.stringify(form_data)
            }

            let res = await fetch(parameters.url + 'order/newOrder', config)
            let data = await res.json();

            if (data.status) {
                location.href = data.message.process_url;
            }

        } catch (error) {
            this.setState({
                error
            })
        }
    }

    handleChange(e) {
        this.setState({
            form: {
                ...this.state.form,
                [e.target.name]: e.target.value
            }
        })
    }

    handleClick(e) {
        e.preventDefault();
        let id = e.target.value

        this.setState({
            productId: id
        })

        this.state.listProducts.forEach(product_ => {
            if (product_.id == id) {
                this.setState({
                    product: {
                        'name': product_.name,
                        'price': product_.price,
                        'id': product_.id
                    }

                })
            }
        });

    }

    async componentDidMount() {
        try {

            this.getInfoProduct();

            let res2 = await fetch(parameters.url + 'product/listProducts', {
                method: 'POST',
                headers: parameters.headers
            }
            )
            let dataListProducts = await res2.json();
            this.setState({
                listProducts: dataListProducts
            })

        } catch (error) {
            this.setState({
                error
            })
        }
    }

    async getInfoProduct() {
        let res = await fetch(parameters.url + 'product/product/' + this.state.productId, {
            method: 'GET',
            headers: parameters.headers
        }
        )
        let data = await res.json();
        this.setState({
            product: data
        })
    }
    render() {
        return (
            <div className="container">
                <a href="/listOrder/" target="_selt">
                    <button className='btn btn-lg btn-block btn-outline-warning' type="button">Ver Ordenes</button>
                </a>
                <div className="row justify-content-center">
                    <div className="col-md-12-m-t-md">
                        <DetailProduc
                            detailProduc={this.state.product}
                            productId={this.state.productId}
                        />
                    </div>
                    <div className="col-md-12">
                        <TransferForm
                            form={this.state.form}
                            onChange={this.handleChange}
                            onSubmit={this.handleSubmit}
                        />
                    </div>
                </div>
                <div className="m-t-md">
                    <ListProducts
                        products={this.state.listProducts}
                        onClick={this.handleClick}
                    />
                </div>
            </div>
        );
    }
}

if (document.getElementById('content_order')) {
    ReactDOM.render(<Index />, document.getElementById('content_order'));
}