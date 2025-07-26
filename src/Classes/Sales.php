<?php 

namespace Tickets;

use Tickets\AbstractClass;

class Sales extends AbstractClass{
    private array $columns = [
        "id",
        "id_cliente",
        "id_ingresso",
        "id_vendedor",
        "valor_total",
        "data_venda"
    ];

} 

?>