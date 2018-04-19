import {Injectable} from '@angular/core';
import {Headers, Http, RequestOptions} from '@angular/http';
import 'rxjs/add/operator/toPromise';
import {environment} from '../environments/environment';
import {Specification} from './model/specification';

@Injectable()
export class MainService {

    constructor(private http: Http) {
    }

    getSpecifications(id_product: number): Promise<Specification[]> {
        const url = `${environment.apiUrl}index.php?route=product/product/options/&product_id=${id_product}`;
        return this.http.get(url)
            .toPromise()
            .then(response => response.json() as Specification[])
            .catch(this.handleError);
    }

    addToCart(data): Promise<any> {
        const headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'});
        const options = new RequestOptions({ headers: headers });
        console.log('addToCart()',  JSON.stringify(data));
        return this.http.post(`${environment.apiUrl}index.php?route=checkout/cart/add`, data, options).toPromise();
    }

    private handleError(error: any): Promise<any> {
        console.error('An error occurred', error);
        return Promise.reject(error.message || error);
    }
}
