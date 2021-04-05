import React from 'react'

const DetailProduc = ({detailProduc}) => (
    <div>
        <p className="title"> {detailProduc.name} </p>
        <strong className="text-danger">Valor a pagar $ {detailProduc.price} </strong>
    </div>
)

export default DetailProduc
