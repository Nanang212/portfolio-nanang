import AdminLayout from '@/Layouts/AdminLayout';
import { Link, router, usePage } from '@inertiajs/react';
import { Plus, Pencil, Trash2, Building2, GripVertical, ChevronUp, ChevronDown, ChevronDown as Expand } from 'lucide-react';
import { useState, useRef } from 'react';

function PeriodLabel({ start, end, isCurrent }) {
    const fmt = (d) => {
        if (!d) return '';
        const date = new Date(d);
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    };
    return (
        <span className="text-xs text-slate-400 dark:text-slate-500">
            {fmt(start)} — {isCurrent ? <span className="text-green-500 font-medium">Present</span> : fmt(end)}
        </span>
    );
}

export default function ExperienceIndex({ experiences: initialExperiences }) {
    const { props } = usePage();
    const flash = props.flash || {};
    const [experiences, setExperiences] = useState(initialExperiences || []);
    const [saving, setSaving] = useState(false);
    const [saved, setSaved] = useState(false);
    const [expanded, setExpanded] = useState({});

    const dragItem = useRef(null);
    const dragOverItem = useRef(null);

    const destroy = (id) => confirm('Delete this experience?') && router.delete(`/admin/experiences/${id}`);

    const toggleExpand = (id) => setExpanded(prev => ({ ...prev, [id]: !prev[id] }));

    const moveUp = (index) => {
        if (index === 0) return;
        const updated = [...experiences];
        [updated[index - 1], updated[index]] = [updated[index], updated[index - 1]];
        setExperiences(updated);
        saveOrder(updated);
    };

    const moveDown = (index) => {
        if (index === experiences.length - 1) return;
        const updated = [...experiences];
        [updated[index], updated[index + 1]] = [updated[index + 1], updated[index]];
        setExperiences(updated);
        saveOrder(updated);
    };

    const onDragStart = (e, index) => {
        dragItem.current = index;
        e.dataTransfer.effectAllowed = 'move';
    };

    const onDragEnter = (e, index) => {
        dragOverItem.current = index;
        e.preventDefault();
    };

    const onDragOver = (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    };

    const onDrop = (e) => {
        e.preventDefault();
        if (dragItem.current === null || dragOverItem.current === null) return;
        if (dragItem.current === dragOverItem.current) return;
        const updated = [...experiences];
        const [dragged] = updated.splice(dragItem.current, 1);
        updated.splice(dragOverItem.current, 0, dragged);
        dragItem.current = null;
        dragOverItem.current = null;
        setExperiences(updated);
        saveOrder(updated);
    };

    const saveOrder = async (ordered) => {
        setSaving(true);
        setSaved(false);
        try {
            await fetch('/admin/experiences/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ order: ordered.map(e => e.id) }),
            });
            setSaved(true);
            setTimeout(() => setSaved(false), 2000);
        } catch (err) {
            console.error(err);
        } finally {
            setSaving(false);
        }
    };

    return (
        <AdminLayout title="Experience">
            <div className="space-y-6">
                {flash.success && (
                    <div className="p-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-xl text-sm border border-green-200 dark:border-green-700">
                        ✓ {flash.success}
                    </div>
                )}

                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <h2 className="font-bold text-slate-900 dark:text-white text-xl">Work Experience</h2>
                        {saving && <span className="text-xs text-slate-400 animate-pulse">Saving order...</span>}
                        {saved && <span className="text-xs text-green-500">✓ Order saved!</span>}
                    </div>
                    <Link href="/admin/experiences/create" className="btn-primary text-sm">
                        <Plus size={16}/> Add Experience
                    </Link>
                </div>

                <p className="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                    <GripVertical size={12}/> Drag cards to reorder, or use ↑↓ buttons. Click a card to expand description.
                </p>

                <div className="space-y-3">
                    {experiences.map((exp, index) => (
                        <div
                            key={exp.id}
                            draggable
                            onDragStart={(e) => onDragStart(e, index)}
                            onDragEnter={(e) => onDragEnter(e, index)}
                            onDragOver={onDragOver}
                            onDrop={onDrop}
                            className="card overflow-hidden transition-all cursor-grab active:cursor-grabbing active:opacity-60 active:ring-2 active:ring-primary-400"
                        >
                            {/* Card header */}
                            <div className="p-4 flex items-start gap-3">
                                {/* Drag handle + order */}
                                <div className="flex flex-col items-center gap-0.5 shrink-0 pt-0.5">
                                    <GripVertical size={16} className="text-slate-300 dark:text-slate-600"/>
                                    <button onClick={(e) => { e.stopPropagation(); moveUp(index); }}
                                        disabled={index === 0}
                                        className="text-slate-400 hover:text-blue-500 disabled:opacity-20 transition-colors">
                                        <ChevronUp size={14}/>
                                    </button>
                                    <span className="text-xs font-mono text-slate-400 leading-none">{index + 1}</span>
                                    <button onClick={(e) => { e.stopPropagation(); moveDown(index); }}
                                        disabled={index === experiences.length - 1}
                                        className="text-slate-400 hover:text-blue-500 disabled:opacity-20 transition-colors">
                                        <ChevronDown size={14}/>
                                    </button>
                                </div>

                                {/* Content */}
                                <div className="flex-1 min-w-0">
                                    <div className="flex items-start justify-between gap-2">
                                        <div>
                                            <div className="flex items-center gap-2 flex-wrap">
                                                <Building2 size={15} className="text-primary-600 shrink-0"/>
                                                <span className="font-bold text-slate-900 dark:text-white">{exp.company}</span>
                                                {exp.is_current && (
                                                    <span className="badge bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs">● Current</span>
                                                )}
                                            </div>
                                            <p className="text-primary-600 dark:text-primary-400 text-sm mt-0.5">{exp.role}</p>
                                            <PeriodLabel start={exp.period_start} end={exp.period_end} isCurrent={exp.is_current}/>
                                        </div>

                                        {/* Actions */}
                                        <div className="flex gap-1 shrink-0">
                                            <button onClick={() => toggleExpand(exp.id)}
                                                className={`btn-ghost p-1.5 text-xs transition-transform ${expanded[exp.id] ? 'rotate-180' : ''}`}
                                                title="Show description">
                                                <ChevronDown size={14}/>
                                            </button>
                                            <Link href={`/admin/experiences/${exp.id}/edit`} className="btn-ghost p-1.5">
                                                <Pencil size={14}/>
                                            </Link>
                                            <button onClick={() => destroy(exp.id)} className="btn-ghost p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                <Trash2 size={14}/>
                                            </button>
                                        </div>
                                    </div>

                                    {/* Tech stack */}
                                    <div className="flex flex-wrap gap-1.5 mt-2">
                                        {(exp.tech_stack || []).slice(0, 6).map(t => (
                                            <span key={t} className="badge-slate text-xs">{t}</span>
                                        ))}
                                        {(exp.tech_stack || []).length > 6 && (
                                            <span className="badge-slate text-xs">+{exp.tech_stack.length - 6}</span>
                                        )}
                                    </div>
                                </div>
                            </div>

                            {/* Expandable description */}
                            {expanded[exp.id] && (
                                <div className="border-t border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 px-4 py-3 space-y-3">
                                    {(exp.projects || []).length > 0 ? (
                                        <div className="space-y-3">
                                            <p className="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Projects / Responsibilities</p>
                                            {exp.projects.map((proj, i) => (
                                                <div key={i} className="rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3">
                                                    <p className="font-medium text-slate-800 dark:text-white text-sm">📌 {proj.name}</p>
                                                    {proj.description_en && (
                                                        <p className="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">{proj.description_en}</p>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    ) : (
                                        <p className="text-slate-400 text-xs italic">No project description. Click Edit to add details.</p>
                                    )}
                                </div>
                            )}
                        </div>
                    ))}

                    {(!experiences || experiences.length === 0) && (
                        <div className="card p-10 text-center text-slate-400">
                            <Building2 size={40} className="mx-auto mb-3 opacity-20"/>
                            <p>No experience records yet. Add one!</p>
                        </div>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
