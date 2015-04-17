<?php
function crimes($crimes)
{
    if ($crimes == '187V') return 'Vehicular Manslaughter';
    elseif ($crimes == '187') return 'Manslaughter';
    elseif ($crimes == '901') return 'Escaping Jail';
    elseif ($crimes == '261') return 'Rape';
    elseif ($crimes == '261A') return 'Attempted Rape';
    elseif ($crimes == '215') return 'Attempted Auto Theft';
    elseif ($crimes == '213') return 'Use of Illegal explosives';
    elseif ($crimes == '211') return 'Robbery';
    elseif ($crimes == '207') return 'Kidnapping';
    elseif ($crimes == '207A') return 'Attempted Kidnapping';
    elseif ($crimes == '487') return 'Grand Theft';
    elseif ($crimes == '488') return 'Petty Theft';
    elseif ($crimes == '480') return 'Hit and Run';
    elseif ($crimes == '481') return 'Drug Possession';
    elseif ($crimes == '482') return 'Intend to Distribute';
    elseif ($crimes == '483') return 'Drug Trafficking';
    elseif ($crimes == '459') return 'Buglary';
    elseif ($crimes == '666') return 'Tax Evasion';
    else return $crimes;
}