import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of, throwError } from "rxjs"
import { map, catchError } from "rxjs/operators";

import { ConstantsService } from "./constants.service";

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  public apiEndPoint:string;
  public data;

  constructor(
    private httpClient: HttpClient,
    private constantsService: ConstantsService
  ) {
    this.apiEndPoint = this.constantsService.baseUrl + '/auth'
  }

  login( in_data ):Observable<any>{

    let formData: FormData = new FormData(); 
    formData.append('universityEmail', in_data.universityEmail); 
    formData.append('password', in_data.password);
    
    return this.httpClient.post( 
      `${this.apiEndPoint}/login`, 
      formData
      )
      .pipe(
        map((e:Response)=> e),
        catchError((e:Response)=> throwError(e))
      );
  }

  forgotPassword( in_data ):Observable<any>{

    let formData: FormData = new FormData(); 
    formData.append('universityEmail', in_data.universityEmail); 
    
    return this.httpClient.post( 
      `${this.constantsService.baseUrl}/forgot/password`, 
      formData
      )
      .pipe(
        map((e:Response)=> e),
        catchError((e:Response)=> throwError(e))
      );
  }
}
