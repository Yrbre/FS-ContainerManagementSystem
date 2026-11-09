<?php 

namespace App\Enums;

class ContainerStatusEnum
{
    const O = "O";
    const TSO = "TSO";
    const SO = "SO";
    const S = "S";
    const SOI = "SOI";
    const TSOI = "TSOI";
    const TSO_MAINTENANCE = 'Maintenance';
    const TSO_UPGRADE = 'Upgrade & Repair';
    
    const COLOR_O = '#FFFFFF';
    const COLOR_SO = '#FFFF00';
    const COLOR_TSO_MAINTENANCE = '#F4B083';
    const COLOR_TSO_UPGRADGE = '#C55A11';
    const COLOR_TSO_GENERAL = '#f0c1a2';
    const COLOR_S = '#FF0000';
    const COLOR_SOI = '#f5e342';
    const COLOR_TSOI = '#bcc9ab';

}