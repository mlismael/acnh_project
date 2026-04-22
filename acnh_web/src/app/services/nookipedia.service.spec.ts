import { TestBed } from '@angular/core/testing';
import { HttpClientTestingModule, HttpTestingController } from '@angular/common/http/testing';
import { NookipediaService } from './nookipedia.service';

describe('NookipediaService', () => {
    let service: NookipediaService;
    let httpMock: HttpTestingController;

    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [HttpClientTestingModule],
            providers: [NookipediaService]
        });
        service = TestBed.inject(NookipediaService);
        httpMock = TestBed.inject(HttpTestingController);
    });

    afterEach(() => {
        httpMock.verify();
    });
e
    it('should be created', () => {
        expect(service).toBeTruthy();
    });

    it('should get villagers', () => {
        const mockResponse = { status: 'success', data: [{ name: 'Bob', species: 'Cat', personality: 'Cranky', gender: 'Male', birthday_month: 'January' }] };

        service.getVillagers().subscribe(data => {
            expect(data).toEqual([{ name: 'Bob', species: 'Gato', personality: 'Gruñón', gender: 'Macho', birthday_month: 'Enero' }]);
        });

        const req = httpMock.expectOne(req => req.url.includes('index.php') && req.params.get('accion') === 'listarAldeanos');
        expect(req.request.method).toBe('GET');
        req.flush(mockResponse);
    });

    it('should get collectibles', () => {
        const mockResponse = { status: 'success', data: [{ name: 'Bass', location: 'River' }] };

        service.getCollectibles('fish').subscribe(data => {
            expect(data).toEqual([{ name: 'Bass', location: 'Río' }]);
        });

        const req = httpMock.expectOne(req => req.url.includes('index.php') && req.params.get('accion') === 'listarColeccionables' && req.params.get('type') === 'fish');
        expect(req.request.method).toBe('GET');
        req.flush(mockResponse);
    });

    it('should get events', () => {
        const mockResponse = { status: 'success', data: [{ event: 'Festivale' }] };

        service.getEvents().subscribe(data => {
            expect(data).toEqual([{ event: 'Festivale' }]);
        });

        const req = httpMock.expectOne(req => req.url.includes('index.php') && req.params.get('accion') === 'listarEventos');
        expect(req.request.method).toBe('GET');
        req.flush(mockResponse);
    });

    it('should get detail', () => {
        const mockResponse = { status: 'success', data: [{ name: 'Bob', species: 'Cat', personality: 'Cranky', gender: 'Male', birthday_month: 'January' }] };

        service.getDetail('villagers', 'Bob').subscribe(data => {
            expect(data).toEqual([{ name: 'Bob', species: 'Gato', personality: 'Gruñón', gender: 'Macho', birthday_month: 'Enero' }]);
        });

        const req = httpMock.expectOne(req => req.url.includes('index.php') && req.params.get('accion') === 'buscarDetalle' && req.params.get('resource') === 'villagers' && req.params.get('name') === 'Bob');
        expect(req.request.method).toBe('GET');
        req.flush(mockResponse);
    });
});