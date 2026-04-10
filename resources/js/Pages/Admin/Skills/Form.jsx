import AdminLayout from '@/Layouts/AdminLayout';
import { Link, useForm } from '@inertiajs/react';
import { ArrowLeft, Save } from 'lucide-react';

const CATEGORIES = ['Backend', 'Frontend', 'DevOps', 'Database', 'Storage', 'Cache', 'Mobile', 'Other'];
const LEVELS = ['beginner', 'intermediate', 'advanced', 'expert'];

export default function SkillForm({ skill }) {
    const isEditing = !!skill;
    const { data, setData, post, put, processing, errors } = useForm({
        name:     skill?.name || '',
        category: skill?.category || 'Backend',
        level:    skill?.level || 'intermediate',
        order:    skill?.order || 0,
        icon:     skill?.icon || '',
    });

    const submit = (e) => {
        e.preventDefault();
        isEditing ? put(`/admin/skills/${skill.id}`) : post('/admin/skills');
    };

    return (
        <AdminLayout title={isEditing ? 'Edit Skill' : 'Add Skill'}>
            <div className="max-w-lg">
                <Link href="/admin/skills" className="btn-ghost text-sm mb-6 inline-flex">
                    <ArrowLeft size={16}/> Back to Skills
                </Link>

                <form onSubmit={submit} className="card p-6 space-y-5">
                    <div>
                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Skill Name *</label>
                        <input className="input" value={data.name} onChange={e => setData('name', e.target.value)} placeholder="e.g. Laravel"/>
                        {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name}</p>}
                    </div>

                    <div className="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Category *</label>
                            <select className="input" value={data.category} onChange={e => setData('category', e.target.value)}>
                                {CATEGORIES.map(c => <option key={c} value={c}>{c}</option>)}
                            </select>
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Level *</label>
                            <select className="input" value={data.level} onChange={e => setData('level', e.target.value)}>
                                {LEVELS.map(l => <option key={l} value={l} className="capitalize">{l}</option>)}
                            </select>
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Order (display priority)</label>
                        <input type="number" className="input" value={data.order} onChange={e => setData('order', e.target.value)} min="0"/>
                    </div>

                    <button type="submit" disabled={processing} className="btn-primary w-full justify-center">
                        <Save size={16}/> {isEditing ? 'Save Changes' : 'Add Skill'}
                    </button>
                </form>
            </div>
        </AdminLayout>
    );
}
