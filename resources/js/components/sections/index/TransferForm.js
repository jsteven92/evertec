import React from 'react'

const TransferForm = ({form, onChange, onSubmit}) => (
    <form 
    className="form-inline justify-content-center"
    onSubmit={onSubmit}
    >
        <div className="form-goup mb-2">
            <input
                type="text"
                className="form-control"
                placeholder="Nombre"
                name="customer_name"
                value={form.customer_name}
                onChange={onChange}
            />
            <input
                type="text"
                className="form-control"
                placeholder="Email"
                name="customer_email"
                value={form.customer_email}
                onChange={onChange}
            />
            <input
                type="text"
                className="form-control"
                placeholder="Número de celular"
                name="customer_mobile"
                value={form.customer_mobile}
                onChange={onChange}
            />
        </div>

        <button
            type="submit"
            className="btn btn-primary mb-2"
        >Pague con place<span className="text-warning">to</span>pay</button>

    </form>
)

export default TransferForm