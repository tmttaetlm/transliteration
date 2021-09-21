Import-Module ActiveDirectory
$users = Import-CSV C:\script\Translit-output.csv
 
$users | ForEach-Object {
    # Get students data from translit-table
    $upn = $_.UserPrincipalName
    $givenname = $_.GivenName
    $surname = $_.Surname
    $sam = $_.sAMAccountName
    #$name = $_.Name
    $dispname = $_.DisplayName
    $cmail = $_.EmailAddress
    $pass = $_.AccountPassword
    $Title = $_.Title
    $Company = $_.Company
    $City = $_.City
    $phone = $_.MobilePhone
    $StreetAddress = $_.StreetAddress
    $class = $_.Class
    $amail = $_.Altemail
    $iin = $_.IIN
    $role = "student"
    
    # Set OU by script generator
    $ou = "%ou%"
           
    if (Get-ADUser -Filter {UserPrincipalName -eq $upn})
    {
        Write-Host "User exists: $($upn)"
        # Set IP by script generator
        Set-ADUser -Server %ip% -Identity $sam -GivenName $givenname -Surname $surname -DisplayName $name -sAMAccountName $sam -OtherAttributes @{nISEDUKZIIN=$iin;nISEDUKZCLASS=$class;nISEDUKZALTEMAIL=$email;nISEDUKZROLE="student"}
        return
    }
    else
    {
    # Set IP, PasswordNeverExpires, ChangePasswordAtLogon, Enabled, CannotChangePassword by script generator
        New-ADUser -Server %ip% `
        -UserPrincipalName $upn `
        -GivenName $givenname `
        -Surname $surname `
        -sAMAccountName $sam `
        -Name $dispname `
        -DisplayName $dispname `
        -EmailAddress $cmail `
        -OfficePhone $phone `
        -Description $class `
        -Title $Title `
        -Department $Company `
        -Company $Company `
        -City $City `
        -MobilePhone $phone `
        -StreetAddress $StreetAddress `
        -Path $ou `
        -AccountPassword (ConvertTo-SecureString $pass -AsPlainText -Force) `
        -PasswordNeverExpires %pne% `
        -Enabled %en% `
        -ChangePasswordAtLogon %cpl% `
        -CannotChangePassword %ccp% `
        -OtherAttributes @{'nISEDUKZIIN'=$iin;'nISEDUKZCLASS'=$class;'nISEDUKZALTEMAIL'=$amail;'nISEDUKZROLE'=$role} 
        Write-Host "Mail: $($upn), Password: $($pass)"
        
    }
}