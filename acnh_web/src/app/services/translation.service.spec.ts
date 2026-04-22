import { TestBed } from '@angular/core/testing';
import { TranslationService } from './translation.service';

describe('TranslationService', () => {
  let service: TranslationService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TranslationService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });

  it('should translate villager species', () => {
    const villager = { name: 'Bob', species: 'Cat', personality: 'Cranky', gender: 'Male', birthday_month: 'January' };
    const translated = service.translateVillager(villager);
    expect(translated.species).toBe('Gato');
    expect(translated.personality).toBe('Gruñón');
    expect(translated.gender).toBe('Macho');
    expect(translated.birthday_month).toBe('Enero');
  });

  it('should translate collectible location', () => {
    const collectible = { name: 'Bass', location: 'River' };
    const translated = service.translateCollectible(collectible);
    expect(translated.location).toBe('Río');
  });

  it('should return original value if not in map', () => {
    const villager = { species: 'Unknown', personality: 'Unknown' };
    const translated = service.translateVillager(villager);
    expect(translated.species).toBe('Unknown');
    expect(translated.personality).toBe('Unknown');
  });
});