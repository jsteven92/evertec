import React from 'react'

const ListProducts = ({ products, onClick }) => (
    <div>
        <h4>Lista de productos</h4>
        <table className="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {products.map((product) => (
                    <tr key={product.id} >
                        <td>{product.name}</td>
                        <td>{product.price}</td>
                        <td>
                            <button type="button" onClick={onClick} value={product.id} className="btn btn-xs btn-block btn-primary">Comprar</button></td>
                    </tr>
                ))}

            </tbody>
        </table>
    </div>
)

export default ListProducts