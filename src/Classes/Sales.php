<?php 

namespace Tickets;

use Tickets\AbstractClass;

class Sales extends AbstractClass{
    private array $columns = [
        "id",
        "id_ingresso",
        "id_cliente",
        "id_vendedor",
        "valor",
        "data_compra"
    ];

} 

?>